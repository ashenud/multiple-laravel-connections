<?php

namespace Database\Factories\Oracle;

use App\Models\Oracle\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pro_name' => $this->faker->unique()->company(),        
            'pro_no' => $this->faker->unique()->numberBetween($min = 100000, $max = 999999),
            'pro_weight' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 150),
            'pro_pack_size' => $this->faker->numberBetween($min = 1, $max = 50),
            'pro_exp_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
