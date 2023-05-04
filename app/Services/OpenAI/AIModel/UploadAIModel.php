<?php
namespace App\Services\OpenAI\AIModel;

use App\Services\OpenAI\AIModel\AIModelService;
use Illuminate\Http\Request;
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
        $yourApiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);
        
        $openAIModels = $this->aiModelService->createNewModel($client, $request);

        return $openAIModels;
    }
}