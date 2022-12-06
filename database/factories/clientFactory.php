<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\client>
 */
class clientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $firstname = $this->faker->firstName();
        $lastname = $this->faker->lastName();
        return [
            'client_id' =>'2022-'.$this->faker->unique()->numberBetween(1111,9999),
            'account_name'=>$lastname .' '. $firstname,
            'first_name' => $firstname,
            'last_name' => $lastname,
            'middle_name' => $this->faker->lastName(),
            'area_id' => $this->faker->numberBetween(1,2),
            'address' => $this->faker->address(),
            'contact_number'=>$this->faker->phoneNumber(),
            'business'=>$this->faker->name(),
            'income'=>$this->faker->numberBetween(900000000,9999999999),
            'is_active'=>1,
            'created_at' => now()
        ];
    }
}
