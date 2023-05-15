<?php
namespace App\Services\OpenAI\AIModel;

use App\Models\AIModel;
use App\Models\FineTuneJob;
use App\Services\OpenAI\AIModel\AIModelService;
use App\Services\OpenAI\AIModel\DownloadAIModel;
use App\Services\OpenAI\AIModel\FineTuneJob\DownloadFineTuneJob;
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
            
            $aiModel = AIModel::firstOrCreate ([
                'openai_id' => $openAIModel->id,
                'user_id' =>  Auth::user()->id
            ]);

            $aiModel->fill($downloadAIModel->getAIModelAttributes($openAIModel));
            $aiModel->save();
        }  
        
        return AIModel::all();
    }    

    public function getModelById(): object
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        return $this->aiModelService->getAModel($client, 'curie:ft-personal-2023-05-10-13-38-59');
    }

    public function getInfoAboutModel(): object
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        return $this->aiModelService->getInfoAboutModel($client,'ft-oBC2C1HzgsewD8GAhRUPVct4');
    }
}