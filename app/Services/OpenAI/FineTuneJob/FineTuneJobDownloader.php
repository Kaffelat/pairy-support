<?php
namespace App\Services\OpenAI\FineTuneJob;

use App\Models\AIFile;
use App\Models\AIModel;
use App\Models\AIModelResultFile;
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

    /**
    * Gets all FineTuneJobs that matches a a model in the db
    */
    public function getAllFineTuneJobs(): Collection
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        $downloadFineTuneJob = new DownloadFineTuneJob;

        # Eager loads AIModel, AIFiles and AIModelResultFiles and puts them in an array where the key is there openai_id
        $aiModels = AIModel::all()->keyBy('openai_id');
        $aiFiles = AIFile::all()->keyBy('openai_id');
        $aiModelResultFiles = AIModelResultFile::all()->keyBy('openai_id');

        foreach ($this->aiModelService->listAllFineTuneJobs($client)->data as $jobInfo) {
            $openaiModelId = $jobInfo->fineTunedModel;

            # If a AIModel's OpenAIID matches a AIModel in the database then procede else it goes on to the next model.
            if ($aiModel = $aiModels->get($openaiModelId)) {

                $openaiFileId = $jobInfo->trainingFiles[0]->id;
                $openaiResultFileId = $jobInfo->resultFiles[0]->id;

                $aiFile = $aiFiles->get($openaiFileId);
                $aiModelResultFile = $aiModelResultFiles->get($openaiResultFileId);
    
                $fineTuneJob = FineTuneJob::firstOrCreate([
                    'openai_id' => $jobInfo->id
                ]);

                $fineTuneJob->fill($downloadFineTuneJob->getFineTuneJobAttributes($jobInfo, $aiModel, $aiFile, $aiModelResultFile));

                $fineTuneJob->save();
            }
        }
        return FineTuneJob::all();
    }

    /**
    * Gets a specific fineTuneJob from it's id on OpenAI
    */
    public function getAFineTuneJob(string $openAIModelId)
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        return $this->aiModelService->getAModelsFineTuneJobs($client, $openAIModelId);
    }

    /**
    * Gets all fineTuneJobs that a AIModel has
    */
    public function getAllFineTuneJobsForAModel(string $openAIModelId)
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);
        
        foreach ($this->aiModelService->listAllFineTuneJobs($client) as $fineTuneJob) {
            
            if ($aiModel = AIModel::where('openai_id', $openAIModelId)->first()) {

                return FineTuneJob::where('ai_model_id',$aiModel->id)->get();
            }
        }
    }
}
