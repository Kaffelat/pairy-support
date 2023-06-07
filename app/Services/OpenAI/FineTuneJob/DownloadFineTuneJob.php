<?php
namespace App\Services\OpenAI\FineTuneJob;

use App\Models\AIFile;
use App\Models\AIModel;
use App\Services\OpenAI\AIFile\AIFileService;
use App\Services\OpenAI\AIModelResultFile\AIModelResultFileDownloader;
use App\Services\OpenAI\AIModelResultFile\AIModelResultFileService;
use stdClass;

class DownloadFineTuneJob 
{
    /**
    * Sets the attributes of a FineTuneJob
    */
    public function getFineTuneJobAttributes(object $jobInfo, AIModel $aiModel): array
    {
        return [
            'ai_model_id' => $aiModel->id,
            'ai_model_result_file_id' => $this->makeResultFile($jobInfo),
            'type' => $jobInfo->model,
            'epochs' => $jobInfo->hyperparams->nEpochs,
            'batch_size'=> $jobInfo->hyperparams->batchSize,
            'learning_rate_multiplier'=> $jobInfo->hyperparams->learningRateMultiplier,
            'prompt_loss_weight' => $jobInfo->hyperparams->promptLossWeight,
        ];
    }

    /**
    * Retrives the resultfile that matches the id in the finetunejob on OpenAI
    */
    public function makeResultFile(object $jobInfo): string
    {
        $aiModelResultFileService = new AIModelResultFileService;

        $aiModelResultFileDownloader = new AIModelResultFileDownloader($aiModelResultFileService);

        $aiModelResultFile = $aiModelResultFileDownloader->makeAModelResultFile($jobInfo->resultFiles[0]->id);

        return $aiModelResultFile->id;
    }
    
    /**
    * get the id of an AIFile
    */
    public function getAIFileId(AIFile $aiFile): array
    {
        return [
            'ai_file_id' => $aiFile->id
        ];
    }
}