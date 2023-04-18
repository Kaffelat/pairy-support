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

    public function getAllAIModels()
    {

        $yourApiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);
        
        $aiModel = new AIModel();
        $downloadAIModel = new DownloadAIModel;

        $openAIModels = $this->aiModelService->listAllModels($client);
        dd($openAIModels);
            foreach ($openAIModels->data as $newVersionAIModel) {
                if ($aiModel::where('openai_id',$newVersionAIModel->id)->count() > 0) {
                    
                    $downloadAIModel->updateAIModelInDB($newVersionAIModel, $aiModel);
                    
                }
                else {
                    
                    $AIFile = new AIModel();
                    $AIFile->fill($downloadAIModel->getAIModelAttributes($aiModel));
                    $AIFile->save();
                }
            }
            return $openAIModels;
    }
}