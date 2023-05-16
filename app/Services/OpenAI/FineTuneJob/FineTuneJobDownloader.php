<?php
namespace App\Services\OpenAI\FineTuneJob;

use App\Models\AIModel;
use App\Models\FineTuneJob;
use App\Services\OpenAI\AIModel\AIModelService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use OpenAI;

class FineTuneJobDownloader 
{   
    protected $aiModelService;

    public function __construct(AIModelService $aiFileService)
    {
        $this->aiModelService = $aiFileService;
    }

    public function getAllFineTuneJobs(): Collection
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        $downloadFineTuneJob = new DownloadFineTuneJob;

        foreach ($this->aiModelService->listAllFineTuneJobs($client)->data as $jobInfo) {

            if (AIModel::where('openai_id', $jobInfo->fineTunedModel)->first()) {

                $fineTuneJob = FineTuneJob::firstOrCreate ([
                    'openai_id' => $jobInfo->id,
                ]);

                $fineTuneJob->fill($downloadFineTuneJob->getFineTuneJobAttributes($jobInfo));
                $fineTuneJob->save();
            }
        }

        return FineTuneJob::all();
    }

    public function getAFineTuneJob(string $openAIModelId)
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        return $this->aiModelService->getAModelsFineTuneJobs($client, $openAIModelId);
    }

    public function getAllFineTuneJobsForAModel(string $openAIModelId)
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);
        
        foreach ($this->aiModelService->listAllFineTuneJobs($client) as $a) {
            
            if ($aiModel = AIModel::where('openai_id', $openAIModelId)->first()) {

                return FineTuneJob::where('ai_model_id',$aiModel->id)->get();
            }
        }
    }
}
