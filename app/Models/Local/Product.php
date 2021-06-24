<?php

namespace App\Models\Local;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mysql_local';    

    protected $primaryKey = 'pro_id';

    protected $fillable = [
        'pro_name',
        'pro_no', 
        'pro_weight',
        'pro_pack_size',
        'pro_exp_date'
    ];
}
