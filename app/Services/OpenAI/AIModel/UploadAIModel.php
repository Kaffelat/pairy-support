<?php
namespace App\Services\OpenAI\AIModel;

use App\Services\OpenAI\AIModel\AIModelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenAI;
use stdClass;

class UploadAIModel
{
    protected $aiModelService;

    public function __construct(AIModelService $aiModelService)
    {
        $this->aiModelService = $aiModelService;
    }

    /**
     * creates or trains a model
     */
    public function createOrTrainModel(Request $request): stdClass
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        $openAIModels = $this->aiModelService->createOrTrainModel($client, $request);
        
        return (object)(array)$openAIModels;
    }
}