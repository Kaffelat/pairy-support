<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AIFineTuneJobFactory extends Factory
{
    public function definition(): array
    {
        return [
            'openai_id' => Str::random(30),
            'ai_model_id' => 1,
            'ai_file_id' => 1,
            'ai_model_result_file_id' => 10, 
            'type' => 'test',
            'epochs' => 4,
            'batch_size' => 1,
            'learning_rate_multiplier' => 0.2,
            'prompt_loss_weight' => 0.01,
        ];
    }
}