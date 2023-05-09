<?php
namespace App\Services\OpenAI\AIModel;

use App\Services\OpenAI\AIModel\AIModelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenAI;

class UploadAIModel
{
    protected $aiModelService;

    public function __construct(AIModelService $aiModelService)
    {
        $this->aiModelService = $aiModelService;
    }

    public function makeAIModel(Request $request): object
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);
        
        $openAIModels = $this->aiModelService->createNewModel($client, $request);

        return $openAIModels;
    }
}