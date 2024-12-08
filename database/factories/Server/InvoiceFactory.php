<?php

namespace Database\Factories\Server;

use App\Models\Server\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = $this->faker->numberBetween($min = 1, $max = 100);
        $inv_count = $this->faker->unique()->numberBetween($min = 1, $max = 999999);  
        $invoice_no = 'INV/'.str_pad($user_id,3,0,STR_PAD_LEFT).'/'.str_pad($inv_count,6,0,STR_PAD_LEFT);

        return [
            'inv_no' => $invoice_no,   
            'inv_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'inv_time' => $this->faker->time($format = 'H:i:s', $max = 'now'),
            'inv_user' => $user_id,
            'inv_amount' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 15000),
            'inv_discount' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 1500),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
