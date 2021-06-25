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
    
    protected $table = 'oracle_customers'; 

    protected $primaryKey = 'cus_id';

    public $hasCompositePrimary = false;
    
    public $dateFlag = 'updated_at';

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
