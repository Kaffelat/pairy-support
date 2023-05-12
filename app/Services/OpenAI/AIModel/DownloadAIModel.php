<?php
namespace App\Services\OpenAI\AIModel;

use App\Models\AIFile;
use Exception;

class DownloadAIModel
{
    public function getAIModelAttributes(object $openAIModel): array
    {
        return [
            'type' => $this->getAIModelsModel($openAIModel),
        ];
    }
    
    public function getFileId(object $openAIModel): ?int
    {
        if ($file = AIFile::where('openai_id', $openAIModel->trainingFiles[0]->id)->first()) {
            return $file->id;
        }
        return null;
        
    }

    public function getAIModelsModel(object $openAIModel)
    {
        $id = $openAIModel->id;

        $exploded = explode(":", $id);

        return $exploded[0];
    }

}