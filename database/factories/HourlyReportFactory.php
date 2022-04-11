<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class HourlyReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'pallet_name' => Order::all()->random()->pallet_type,
            'def_id' => $this->faker->numberBetween(1, 6),
            'extra_info' => $this->faker->word,
            'action' => $this->faker->word,
            'abnormality' =>  $this->faker->word,
            'order_id'=>Order::all()->random()->id,
        ];
    }
}


