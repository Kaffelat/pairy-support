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
    
        foreach ($openAIModels as $newVersionAIModel) {
                if ($aiModel::where('openai_id',$newVersionAIModel->id)->count() > 0) {
                    
                    $downloadAIModel->updateAIModelInDB($newVersionAIModel, $aiModel);
                }
                else {
                    $aiFile = new AIModel();
                    $aiFile->fill($downloadAIModel->getAIModelAttributes($newVersionAIModel));
                    $aiFile->save();
                }
            }
            return $openAIModels;
        }

    public function makeNewAIModel()
    {
        $yourApiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);

        $openAIModels = $this->aiModelService->createNewModel($client,'file-eFIFEp23oMQuDJ3d6kR58J9i', '', 'currie');

        return $openAIModels;
    }
}