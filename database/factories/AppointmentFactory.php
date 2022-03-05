<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'client_id' => Client::factory()->create()->id,
            'date' => now(),
            'time' => now(),
            'status' => Appointment::STATUS_SCHEDULED,
            'note' => 'note',
            'order_position' => 0,
        ];
    }

    public function scheduled()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Appointment::STATUS_SCHEDULED,
            ];
        });
    }

    public function closed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Appointment::STATUS_CLOSED,
            ];
        });
    }
}
