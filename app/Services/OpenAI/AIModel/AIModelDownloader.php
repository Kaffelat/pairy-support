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
        
        $aiModel = new AIModel;
        $downloadAIModel = new DownloadAIModel;

        foreach ($this->aiModelService->listAllModels($client) as $openAIModel) {
            try {
                $aiModel = AIModel::firstOrCreate([
                    'openai_id' => $openAIModel->id,
                    'user_id' => 1
                ]);
            }
            catch (Exception $e) {
                throw $e;
            }

            foreach ($this->aiModelService->listAllModelsWithInfo($client)->data as $modelInfo) {
                try {
                    if ($modelInfo->fineTunedModel == $openAIModel->id) {
                    
                        $aiModel->fill($downloadAIModel->getAIModelAttributes($modelInfo));
                        
                        $aiModel->save();
                        }
                    }
                catch (Exception $e) {
                    throw $e;
                }
            }
            return AIModel::all();
        }
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