<?php
namespace App\Services\OpenAI\FineTuneJob;

use App\Models\AIFile;
use App\Models\AIModel;
use App\Models\AIModelResultFile;
use App\Services\OpenAI\AIFile\AIFileService;
use App\Services\OpenAI\AIModelResultFile\AIModelResultFileDownloader;

class DownloadFineTuneJob 
{
    public function getFineTuneJobAttributes(object $jobInfo, AIModel $aiModel, AIFile $aiFile): array
    {
        return [
            'ai_model_id' => $aiModel->id,
            'ai_file_id' => $aiFile->id,
            'ai_model_result_file_id' => $this->makeResultFile($jobInfo),
            'type' => $jobInfo->model,
            'epochs' => $jobInfo->hyperparams->nEpochs,
            'batch_size'=> $jobInfo->hyperparams->batchSize,
            'learning_rate_multiplier'=> $jobInfo->hyperparams->learningRateMultiplier,
            'prompt_loss_weight' => $jobInfo->hyperparams->promptLossWeight,
        ];
    }

    public function makeResultFile(object $jobInfo): string
    {
        $aiFileService = new AIFileService;

        $aiModelResultFileDownloader = new AIModelResultFileDownloader($aiFileService);

        $aiModelResultFile = $aiModelResultFileDownloader->makeAModelResultFile($jobInfo->resultFiles[0]->id);

        return $aiModelResultFile->id;
    }
}