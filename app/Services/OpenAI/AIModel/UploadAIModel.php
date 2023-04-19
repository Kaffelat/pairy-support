<?php
namespace App\Services\OpenAI\AIModel;

use App\Services\OpenAI\AIModel\AIModelService;
use OpenAI;

class UploadAIModel
{
    protected $aiModelService;

    public function __construct(AIModelService $aiModelService)
    {
        $this->aiModelService = $aiModelService;
    }

    public function makeNewAIModel()
    {
        $yourApiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);

        $openAIModels = $this->aiModelService->createNewModel($client,'file-eFIFEp23oMQuDJ3d6kR58J9i', '', 'currie');

        return $openAIModels;
    }
}