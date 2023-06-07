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

        $userId = Auth::user()->id;

        foreach ($this->aiModelService->listAllModels($client) as $openAIModel) {
            try {
                $aiModel = AIModel::firstOrCreate ([
                    'openai_id' => $openAIModel->id,
                    'user_id' =>  $userId
                ]);
                
                $aiModel->fill($downloadAIModel->getAIModelAttributes($openAIModel));
                $aiModel->save();
            }
            
            catch (Exception $e) {
                Log::error("Couldn't get AIModel: \"{$openAIModel}\"");
                throw $e;
            }
        }
        return AIModel::where('user_id', $userId)->get();
    }    
}