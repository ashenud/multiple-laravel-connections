<?php

namespace App\Console\Commands;

use App\Models\Local\IntegrationSyncTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class serverDataIntegration extends Command
{
    protected $truncate = false;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'integration:sync {arg1?} {arg2?}';

    /**
     * Table names in underscore notation
     */
    protected $models = [
        'customer'
    ];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncronizing data from server database table';

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

        $this->info("Starting the integrations.");

        $arg1 = $this->argument('arg1');
        $arg2 = $this->argument('arg2');

        $models = [];

        if($arg2=='truncate'||$arg1=='truncate'){
            $this->truncate= true;
        }

        if($arg1&&$arg1!='truncate'){
            $models = explode(',',$arg1);
        } else {
            $models = $this->models;
        }

        foreach ($models as $name) {
            $this->syncTable($name);
        }
    }

    protected function syncTable($name){
        $time = date('Y-m-d H:i:s.u');
        $this->info("Syncronizing table ".$name." at $time ");

        $model_class = ucfirst(strtolower($name));

        $local_model_path = 'App\Models\Local\\'.$model_class;
        $server_model_path = 'App\Models\Server\\'.$model_class;

        $local_model = new $local_model_path;
        $server_model = new $server_model_path;

        if( !$this->truncate ) {
            $this->syncChanged($local_model,$server_model,$name);
        }else if($this->truncate){
            $this->warn("Truncating table $name");
            $this->truncateAndInsert($local_model,$server_model,$name);
        }
        $this->info("Finished syncronizing table ".$name." at $time ");
    }    

    protected function syncChanged($local_model,$server_model,$name) {

        $primaryKey = $server_model->getKeyName(); // Getting primary key column name
        $time = time();

        // Getting last timestamp
        $check_sync_time = IntegrationSyncTime::where('local_table_name',$name)->first();

        if (!$check_sync_time) {
            $query = $server_model::query();
        } else {

            if(!$check_sync_time->last_sync_status){
                $this->warn("Table is locked. Previous integration not completed yet.");
                return;
            }
            $check_sync_time->last_sync_status = 0;
            $check_sync_time->save();
            $query = $server_model;
        }

        try {

            $results = $query->get();
            $this->info("Fetched ".$results->count()." rows from server connection.");

            DB::beginTransaction();

            if (!$results->isEmpty()) {

                $progress_bar = $this->output->createProgressBar($results->count());
                $progress_bar->setFormat('%current%/%max% [<fg=magenta>%bar%</>] %percent:3s%% %elapsed:6s%/%estimated:-6s%');

                $updated = 0;
                foreach ($results as $key=> $row) {

                    $exists = $local_model::where($primaryKey, $row->{$primaryKey})->latest()->first();
                    $data = [];

                    foreach($local_model->getFillable() as $columnName){
                        $data[$columnName] = $row->{$columnName};
                    }

                    if ($exists) {
                        $updated++;
                        if($server_model->hasCompositePrimary){
                            $primary = $server_model->getKeyName();

                            $where = [];
                            foreach($primary as $column){
                                $where[$column] = $row->{$column};
                            }
                            $exists = $local_model::where($where)->update($data);
                        }
                        else{
                            $exists->update($data);
                        }

                    } else {
                        $exists = $local_model::create($data);
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
            'local_table_name'=> $name
        ]);

        $last_updated->last_sync_time = date('Y-m-d H:i:s',$time);
        $last_updated->last_sync_status = 1;
        $last_updated->save();
    }
    

    protected function truncateAndInsert($local_model,$server_model,$name){
        $local_model::truncate();

        $this->warn("Truncated table $name");

        $results = $server_model::all();

        $this->info("Fetched ".$results->count()." rows from server connection.");

        if (!$results->isEmpty()) {

            $progress_bar = $this->output->createProgressBar($results->count());
            $progress_bar->setFormat('%current%/%max% [<fg=magenta>%bar%</>] %percent:3s%% %elapsed:6s%/%estimated:-6s%');

            foreach ($results as $key=> $row) {

                $data = [];

                foreach($local_model->getFillable() as $name){
                    $data[$name] = $row->{$name};
                }

                $exists = $local_model::create($data);
                
                $progress_bar->advance();
            }

            $progress_bar->finish();
            $this->info("");
            $this->info("Changes affected to ".($key+1)." row(s).");

        }
    }

}
