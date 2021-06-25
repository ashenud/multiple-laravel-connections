<?php

namespace App\Models\Local;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mysql_local';    

    protected $primaryKey = 'inv_id';
    
    public $dateFlag = 'updated_at';

    protected $fillable = [
        'inv_no', 
        'inv_date',
        'inv_time',
        'inv_user',
        'inv_amount',
        'inv_discount'
    ];
}
