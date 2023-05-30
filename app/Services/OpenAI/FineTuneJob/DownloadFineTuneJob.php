<?php
namespace App\Services\OpenAI\FineTuneJob;

use App\Models\AIFile;
use App\Models\AIModel;
use App\Models\AIModelResultFile;

class DownloadFineTuneJob 
{
    public function getFineTuneJobAttributes(object $jobInfo, AIModel $aiModel, AIFile $aiFile, AIModelResultFile $aiModelResultFile): array
    {
        return [
            'ai_model_id' => $aiModel->id,
            'ai_file_id' => $aiFile ? $aiFile->id : null,
            'ai_model_result_file_id' => $aiModelResultFile ? $aiModelResultFile->id : null,
            'type' => $jobInfo->model,
            'epochs' => $jobInfo->hyperparams->nEpochs,
            'batch_size'=> $jobInfo->hyperparams->batchSize,
            'learning_rate_multiplier'=> $jobInfo->hyperparams->learningRateMultiplier,
            'prompt_loss_weight' => $jobInfo->hyperparams->promptLossWeight,
        ];
    }
}