<?php
namespace App\Services\OpenAI\FineTuneJob;

use App\Models\AIFile;
use App\Models\AIModel;
use App\Models\AIModelResultFile;

class DownloadFineTuneJob 
{
    public function getFineTuneJobAttributes(object $jobInfo): array
    {
        return [
            'ai_model_id' => $this->getAIModelId($jobInfo),
            'ai_file_id' => $this->getAIFileId($jobInfo),
            'ai_model_result_file_id' => $this->getAIModelResultFileId($jobInfo),
            'type' => $jobInfo->model,
            'epochs' => $jobInfo->hyperparams->nEpochs,
            'batch_size'=> $jobInfo->hyperparams->batchSize,
            'learning_rate_multiplier'=> $jobInfo->hyperparams->learningRateMultiplier,
            'prompt_loss_weight' => $jobInfo->hyperparams->promptLossWeight,
        ];
    }

    public function getAIModelId(object $jobInfo)
    {
        $openaiModelId = $jobInfo->fineTunedModel;
        
        if ($aiModel = AIModel::where('openai_id',$openaiModelId)->first()) {
            return $aiModel->id;
        };
        return null;
    }

    public function getAIFileId(object $jobInfo)
    {
        $openaiFileId = $jobInfo->trainingFiles[0]->id;

        $aiFile = AIFile::where('openai_id',$openaiFileId)->first();
    
        return $aiFile->id;
    }

    public function getAIModelResultFileId(object $jobInfo)
    {
        $openaiFileId = $jobInfo->resultFiles[0]->id;

       if ($aiModelResultFile = AIModelResultFile::where('openai_id',$openaiFileId)->first()) {
           return $aiModelResultFile->id;
       };
       return null;
    }

    public function getEvents(object $jobInfo)
    {
        $allEvents = [];

        foreach ($jobInfo->events as $events) {
            if (empty($events)) {
                return $allEvents;
            }
            array_push($allEvents,$events);
        }
        return $allEvents;
    }
}