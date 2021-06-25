<?php

namespace App\Models\Mongo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Eloquent\Model;

class ServerInvoice extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mongodb';

    protected $collection = 'server_invoices';

    protected $deleted_at = ['deleted_at'];
    
    public $dateFlag = 'updated_at';

    protected $fillable = [
        'inv_id', 
        'inv_no', 
        'inv_date',
        'inv_time',
        'inv_user',
        'inv_amount',
        'inv_discount'
    ];
}
