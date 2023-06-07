<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AIModelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'openai_id' => Str::random(30),
            'user_id' => 1,
            'type' => 'test',
        ];
    }
}