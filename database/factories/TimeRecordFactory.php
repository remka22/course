<?php

namespace Database\Factories;

use App\Models\TimeRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimeRecord>
 */
class TimeRecordFactory extends Factory
{
    protected $model = TimeRecord::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_record' => null,
            'date' => '2023-05-27 8:30',
            'status' => 0
        ];
    }

    public function suspended()
    {
        return $this->state(function (array $attributes) {
            return [
                'account_status' => 'suspended',
            ];
        });
    }
}
