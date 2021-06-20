<?php

namespace App\Models\Oracle;

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
    protected $connection = 'oracle';    

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
