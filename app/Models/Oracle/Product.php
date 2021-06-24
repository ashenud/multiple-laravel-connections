<?php

namespace App\Models\Oracle;

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
    protected $connection = 'oracle';
    
    protected $table = 'oracle_products';

    protected $primaryKey = 'pro_id';

    public $hasCompositePrimary = false;

    public $dateFlag = 'updated_at';

    protected $fillable = [
        'pro_name',
        'pro_no', 
        'pro_weight',
        'pro_pack_size',
        'pro_exp_date'
    ];
}
