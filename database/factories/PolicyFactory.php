<?php

namespace Database\Factories;

use App\PolicyType;
use App\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Policy>
 */
class PolicyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'policy_number' => $this->faker->unique()->bothify('POLICY####'),
            'customer_name' => $this->faker->name(),
            'policy_type' => $this->faker->randomElement(
                [PolicyType::Health->value, PolicyType::Life->value, PolicyType::Auto->value, PolicyType::Travel->value, PolicyType::Property->value]),
            'premium_amount' => $this->faker->randomFloat(2, 500, 5000),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'status' => $this->faker->randomElement([Status::Pending->value, Status::Active->value, Status::Expired->value]),
        ];
    }
}
