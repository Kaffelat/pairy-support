<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AIFileFactory extends Factory
{
    
    public function definition(): array
    {
        return [
            'openai_id' => Str::random(30),
            'user_id' => 1,
            'name' => fake()->name(),
            'byte_size' => 10, 
            'file_purpose' => 'test',
        ];
    }
}