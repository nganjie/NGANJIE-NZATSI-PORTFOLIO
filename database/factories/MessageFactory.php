<?php

namespace Database\Factories;

use App\Enums\MessageType;
use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Message>
 */
class MessageFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => MessageType::Job,
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'body' => fake()->paragraph(),
        ];
    }

    public function read(): static
    {
        return $this->state(['read_at' => now()]);
    }

    public function archived(): static
    {
        return $this->state(['archived_at' => now()]);
    }
}
