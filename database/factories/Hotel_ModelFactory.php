<?php

namespace Database\Factories;

use App\Models\Hotel_Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel_Model>
 */
class Hotel_ModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Hotel_Model::class;
    use WithFaker;
    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->randomNumber(5),
            'Name' => $this->faker->name,
            'Address' => $this->faker->address,
            'Telephone' => $this->faker->unique()->phoneNumber,
            'Description' => $this->faker->sentence,
            'LocationDetail' => $this->faker->paragraph,
            'IsActive' => $this->faker->boolean,
            'TimeCheckIn' => $this->faker->dateTime,
            'TimeCheckOut' => $this->faker->dateTime,
        ];
    }
}
