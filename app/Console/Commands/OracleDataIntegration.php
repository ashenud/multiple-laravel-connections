<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OracleDataIntegration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'integration:oracle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncronizing data from oracle database table';

    /**
     * Table names in underscore notation
     */
    protected $models = [
        'customer'
    ];

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
    public function handle()
    {
        $name = $this->anticipate('What is your name?', ['Taylor', 'Dayle']);
    }
}
