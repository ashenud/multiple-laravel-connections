<?php

namespace App\Models\Local;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mysql_local';    

    protected $primaryKey = 'cus_id';

    protected $fillable = [
        'cus_name',
        'cus_no', 
        'cus_add1',
        'cus_add2',
        'cus_add3',
        'cus_tel',
        'cus_fax',
        'cus_email',
        'cus_adddate',
        'cus_addtime'
    ];

}
