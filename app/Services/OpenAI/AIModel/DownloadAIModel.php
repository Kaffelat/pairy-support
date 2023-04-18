<?php
namespace App\Services\OpenAI\AIModel;

use App\Models\AIModel;

class DownloadAIModel
{
    public function getAIModelAttributes(object $newVersionAIModel): array
    {
        return [
            'openai_id' => $newVersionAIModel->id,
            'user_id'   => 1,
            'data'      => json_encode(['test for nu']),
            'tokens'    => 0,
            'validering' => 0,
            'traning'   => 1
        ];
    }

    public function updateAIModelInDB(object $newVersionAIModel, AIModel $aiModel): void
    {
        $aiModel::where('openai_id',$newVersionAIModel->id)->update([ 
            'openai_id' => $newVersionAIModel->id,
            'user_id'   => 1,
            'data'      => json_encode(['test for nu22']),
            'tokens'    => 0,
            'validering' => 0,
            'traning'   => 1
            ]);
        
    }
}