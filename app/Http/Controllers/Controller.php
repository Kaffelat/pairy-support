<?php

namespace App\Http\Controllers;

use App\Models\AIModel;
use App\Services\OpenAI\AIFile\UploadAIFiles;
use App\Services\OpenAI\AIModel\AIModelDownloader;
use App\Services\OpenAI\AIModel\AIModelService;
use App\Services\OpenAI\AIModel\UploadAIModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use OpenAI;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function test() {
        $client = OpenAI::client(Auth::user()->openai_api_key);
        $response = $client->fineTunes()->create([
            'training_file' => 'file-s4lKxvHWtNLxJBJdXNBkJ226',
            'model' => 'curie:ft-personal-2023-04-19-12-04-28',
            'n_epochs' => 4,
            'prompt_loss_weight' => 0.01,
        ]);
        
        return $response->toArray();
    }
}