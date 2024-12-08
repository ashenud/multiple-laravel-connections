<?php

namespace Database\Factories\Server;

use App\Models\Server\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $ceated_at = $this->faker->dateTimeThisDecade($max = 'now', $timezone = null);

        return [
            'cus_name' => $this->faker->unique()->company(),        
            'cus_no' => $this->faker->unique()->numberBetween($min = 100000, $max = 999999),
            'cus_add1' => $this->faker->streetAddress(),
            'cus_add2' => $this->faker->streetName(),
            'cus_add3' => $this->faker->city(),
            'cus_tel' => $this->faker->e164PhoneNumber(),
            'cus_fax' => $this->faker->e164PhoneNumber(),
            'cus_email' => $this->faker->unique()->safeEmail(),
            'cus_adddate' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'cus_addtime' => $this->faker->time($format = 'H:i:s', $max = 'now'),
            'created_at' => $ceated_at,
            'updated_at' => $ceated_at
        ];
    }
}
