<?php
namespace App\Services\OpenAI\AIModel;

use App\Models\AIModel;
use App\Services\OpenAI\AIModel\AIModelService;
use App\Services\OpenAI\AIModel\DownloadAIModel;
use OpenAI;

class AIModelDownloader
{   
    protected $aiModelService;

    public function __construct(AIModelService $aiFileService)
    {
        $this->aiModelService = $aiFileService;
    }

    public function getAIModels()
    {

        $yourApiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);
        
        $aiModel = new AIModel;
        $downloadAIModel = new DownloadAIModel;
        
        $openAIModels = $this->aiModelService->listAllModels($client);
        $openAIModelsInfo = $this->aiModelService->listAllModelsWithInfo($client);

        foreach ($openAIModels as $openAIModel) {

            $aiModel = AIModel::firstOrCreate([
                'openai_id' => $openAIModel->id,
                'user_id' => 1
            ]);

            foreach ($openAIModelsInfo->data as $modelInfo) {

                if ($modelInfo->fineTunedModel == $openAIModel->id) {
                
                    $aiModel->fill($downloadAIModel->getAIModelAttributes($modelInfo));
                    
                    $aiModel->save();
                }
            }
        }

        return dd($openAIModelsInfo);
    }    

    public function getModelById()
    {
        $yourApiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);

        return $this->aiModelService->getAModel($client, 'curie:ft-personal-2023-04-19-10-55-48');
    }

    public function getInfoAboutModel()
    {
        $yourApiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);

        return $this->aiModelService->getInfoAboutModel($client,'ft-Yu6XSuF2sGhE851v9VEDLpsM');
    }
}