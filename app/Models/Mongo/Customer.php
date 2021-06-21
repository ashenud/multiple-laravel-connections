<?php

namespace App\Models\Mongo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Eloquent\Model;

class Customer extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mongodb';

    protected $collection = 'customers';

    protected $dates = ['deleted_at'];

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
