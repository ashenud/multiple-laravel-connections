<?php

namespace App\Console\Commands;

use App\Models\Local\IntegrationSyncTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OracleDataIntegration extends Command
{
    protected $truncate = false;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'integration:oracle {models?} {truncate?} {--db=}';

    /**
     * Table names in underscore notation
     */
    protected $models = [
        'customer',
        'product'
    ];

    /**
     * Databases names in underscore notation
     */
    protected $databases = [
        'local',
        'server'
    ];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncronizing data from oracle database table to local and server database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {

        $arg1 = $this->argument('models');
        $arg2 = $this->argument('truncate');
        $db = $this->option('db');
        if($this->validate_signature($arg1,$arg2,$db)) {

            $this->info("Starting the integrations.");

            $models = [];
            if($arg1 == 'truncate' || $arg2 == 'truncate'){
                $this->truncate= true;
            }

            if( isset($arg1) && $arg1 != 'truncate' ) {
                $models = explode(',',$arg1);
            }
            else {
                $models = $this->models;
            }

            foreach ($models as $name) {
                $this->syncTable($name,$db);
            }
        }

    }

    protected function validate_signature($arg1,$arg2,$db) {

        $valid = true;
        if( isset($arg1) && $arg1 != 'truncate' ) {
            $enterd_models = explode(',',$arg1);
            $diff = array_diff($enterd_models,$this->models);
            if(count($diff) > 0) {
                $this->newLine();
                $this->error("                                                   ");
                $this->error("One or more table(s) that you enterd is not exists.");
                $this->newLine();
                $valid = false;
                return false;
            }
        }

        if(isset($arg2) && $arg2 != 'truncate') {
            $this->newLine();
            $this->error("                              ");
            $this->error("Argument two must be truncate.");
            $this->newLine();
            $valid = false;
            return false;
        }
        
        if($db == "") {
            $this->newLine();
            $this->error("                                       ");
            $this->error("Select a database to store oracle data.");
            $this->newLine();
            $valid = false;
            return false;
        }
        elseif (!in_array($db, $this->databases, TRUE)) {
            $this->newLine();
            $this->error("                                       ");
            $this->error("Database that you enterd is not exists.");
            $this->newLine();
            $valid = false;
            return false;
        }

        return $valid;

    }

    protected function syncTable($name,$db){
        $time = date('Y-m-d H:i:s');
        $this->warn("Syncronizing table ".$name." to ".$db." database at $time");

        $model_class = ucfirst(strtolower($name));
        $database = ucfirst(strtolower($db));

        $selected_model_path = 'App\Models\\'.$database.'\\'.$model_class;
        $oracle_model_path = 'App\Models\Oracle\\'.$model_class;

        $selected_model = new $selected_model_path;
        $oracle_model = new $oracle_model_path;

        if( !$this->truncate ) {
            $this->syncChanged($selected_model,$oracle_model,$name,$db);
        }else if($this->truncate){
            $this->warn("Truncating table $name");
            $this->truncateAndInsert($selected_model,$oracle_model,$name,$db);
        }
        $this->info("Finished syncronizing table ".$name." at ".date('Y-m-d H:i:s'));
    }    

    protected function syncChanged($selected_model,$oracle_model,$name,$db) {

        $primaryKey = $oracle_model->getKeyName(); // Getting primary key column name
        $time = time();

        // Getting last timestamp
        $check_sync_time = IntegrationSyncTime::where('selected_table',$name)->where('selected_database',$db)->first();

        if (!$check_sync_time) {
            $query = $oracle_model;
        } else {

            if(!$check_sync_time->last_sync_status){
                $this->warn("Table is locked. Previous integration not completed yet.");
                return;
            }
            $check_sync_time->last_sync_status = 0;
            $check_sync_time->save();

            if($oracle_model->dateFlag && $oracle_model->dateFlag != 'NULL'){
                $query = $oracle_model::where($oracle_model->dateFlag, '>', $check_sync_time->last_sync_time);
            } else {
                $query = $oracle_model;
            }
        }

        try {

            $results = $query->get();
            $this->info("Fetched ".$results->count()." rows from oracle connection.");

            DB::beginTransaction();

            if (!$results->isEmpty()) {

                $progress_bar = $this->output->createProgressBar($results->count());
                $progress_bar->setFormat('<fg=blue;bg=black>%current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%</>');

                $updated = 0;
                foreach ($results as $key=> $row) {

                    $exists = $selected_model::where($primaryKey, $row->{$primaryKey})->latest()->first();
                    $data = [];

                    foreach($selected_model->getFillable() as $columnName){
                        $data[$columnName] = $row->{$columnName};
                    }

                    if ($exists) {
                        $updated++;
                        if($oracle_model->hasCompositePrimary){
                            $primary = $oracle_model->getKeyName();

                            $where = [];
                            foreach($primary as $column){
                                $where[$column] = $row->{$column};
                            }
                            $exists = $selected_model::where($where)->update($data);
                        }
                        else{
                            $exists->update($data);
                        }

                    } else {
                        $exists = $selected_model::create($data);
                    }

                    $progress_bar->advance();

                }

                $progress_bar->finish();
                $this->info("");
                $this->info("Changes affected to ".($key+1)." row(s). ".($updated)." rows updated. ".($key+1-$updated)." rows newly created");
            }
            DB::commit();

        } catch (\Exception $exception) {
            DB::rollback();
            $this->error("Failed to write to $name table. Error:- ".$exception->__toString());
            Storage::put('/public/errors/integration/'.date("Y-m-d").'/'.$name.'.txt',date("H:i:s")."\n".$exception->__toString()."\n\n");
        }

        $last_updated = IntegrationSyncTime::firstOrNew([
            'selected_table'=> $name,
            'selected_database'=> $db
        ]);

        $last_updated->last_sync_time = date('Y-m-d H:i:s',$time);
        $last_updated->last_sync_status = 1;
        $last_updated->save();
    }

    protected function truncateAndInsert($selected_model,$oracle_model,$name,$db){
        $time = time();
        $selected_model::truncate();

        $this->warn("Truncated table $name in $db database");

        $results = $oracle_model::all();

        $this->info("Fetched ".$results->count()." rows from oracle connection.");

        if (!$results->isEmpty()) {

            $progress_bar = $this->output->createProgressBar($results->count());
            $progress_bar->setFormat('<fg=blue;bg=black>%current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%</>');

            foreach ($results as $key=> $row) {

                $data = [];

                foreach($selected_model->getFillable() as $columnName){
                    $data[$columnName] = $row->{$columnName};
                }

                $selected_model::create($data);
                
                $progress_bar->advance();
            }

            $progress_bar->finish();
            $this->info("");
            $this->info("Changes affected to ".($key+1)." row(s).");

        }

        $last_updated = IntegrationSyncTime::firstOrNew([
            'selected_table'=> $name,
            'selected_database'=> $db
        ]);

        $last_updated->last_sync_time = date('Y-m-d H:i:s',$time);
        $last_updated->last_sync_status = 1;
        $last_updated->save();

    }

}
