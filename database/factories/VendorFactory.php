<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VendorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'              => $this->faker->unique()->company(),
            'business_type'     => $this->faker->randomElement(['Individual', 'Corporate']),
            'tax_number'        => $this->faker->numerify('##.###.###.#-###.###'),
            'company_address'   => $this->faker->address(),
            'business_fields'   => $this->faker->randomElements(
                ['Material Procurement','Contractor','Maintenance Service','Transportation','Logistics','General Trading'],
                rand(1, 2)
            ),
            'pic_name'          => $this->faker->name(),
            'pic_position'      => $this->faker->randomElement(['Director','Manager','Owner']),
            // all file_* remain null
        ];
    }
}