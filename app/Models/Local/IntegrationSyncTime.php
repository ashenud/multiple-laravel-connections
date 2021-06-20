<?php

namespace App\Models\Local;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntegrationSyncTime extends Model
{
    use HasFactory;

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mysql_local';

    protected $table = 'integration_sync_time';

    protected $fillable = [
        'server_table_name',
        'local_table_name',
        'last_sync_time',
        'last_sync_status'
    ];

}
