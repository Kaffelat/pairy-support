<?php
namespace App\Services\OpenAI\AIModel;

use App\Models\AIModel;
use App\Services\OpenAI\AIModel\AIModelService;
use App\Services\OpenAI\AIModel\DownloadAIModel;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use OpenAI;

class AIModelDownloader
{   
    protected $aiModelService;

    public function __construct(AIModelService $aiFileService)
    {
        $this->aiModelService = $aiFileService;
    }

    public function getAIModels(): Collection
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);
        
        $downloadAIModel = new DownloadAIModel;
        
        foreach ($this->aiModelService->listAllModels($client) as $openAIModel) {
            $aiModel = new AIModel;
            
            $aiModel = AIModel::firstOrCreate([
                'openai_id' => $openAIModel->id,
                'user_id' =>  Auth::user()->id
            ]);
      
            foreach ($this->aiModelService->listAllModelsWithInfo($client)->data as $modelInfo) {
                if ($modelInfo->fineTunedModel == $aiModel->openai_id) {

                    $aiModel->fill($downloadAIModel->getAIModelAttributes($modelInfo));
                    
                    $aiModel->save();
                }
            }
               
        }
        return AIModel::all();
    }    

    public function getModelById(): object
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        return $this->aiModelService->getAModel($client, 'curie:ft-personal-2023-04-19-10-55-48');
    }

    public function getInfoAboutModel(): object
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        return $this->aiModelService->getInfoAboutModel($client,'ft-Yu6XSuF2sGhE851v9VEDLpsM');
    }
}