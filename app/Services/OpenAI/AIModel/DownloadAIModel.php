<?php
namespace App\Services\OpenAI\AIModel;

use App\Models\AIFile;
use Exception;

class DownloadAIModel
{
    public function getAIModelAttributes(object $openAIModel): array
    {
        return [
            'ai_file_id' => $this->getFileId($openAIModel),
            'type'      => $openAIModel->model,
            'epochs'    => $openAIModel->hyperparams->nEpochs,
            'batch_size'=> $openAIModel->hyperparams->batchSize,
            'learning_rate_multiplier'=> $openAIModel->hyperparams->learningRateMultiplier,
            'prompt_loss_weight' => $openAIModel->hyperparams->promptLossWeight,
        ];
    }
    
    public function getFileId(object $openAIModel): ?int
    {
        foreach ($openAIModel->trainingFiles as $traningFile) {
            if ($file = AIFile::where('openai_id', $traningFile->id)->first()) {
                return $file->id;
            }
            return null;
        }
    }
    
    public function customHandler(object $openAIModel) 
    { 
        
    }

}