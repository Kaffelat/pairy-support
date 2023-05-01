<?php
namespace App\Services\OpenAI\AIModel;

use App\Models\AIFile;
use App\Models\AIModel;

class DownloadAIModel
{
    public function getAIModelAttributes(object $openAIModel): array
    {

        return [
            'ai_file_id' => $this->getFileId($openAIModel),
            'type'      => $openAIModel->model,
            'epochs'    => $openAIModel->hyperparams->nEpochs,
            // 'batchSize'=> $openAIModel->hyperparams->batchSize,
            // 'learningRateMultiplier'=> $openAIModel->hyperparams->learningRateMultiplier,
            // 'promptLossWeight' => $openAIModel->hyperparams->promptLossWeight,
        ];
    }
    
    public function getFileId(object $openAIModel)
    {
        foreach ($openAIModel->trainingFiles as $traningFile) {
            if ($file = AIFile::where('openai_id', $traningFile->id)->first()) {
                return $file->id;
            }
        }
    }
    
    public function customHandler(object $openAIModel) 
    { 
        
    }

}