<?php
namespace App\Services\OpenAI\AIModel;

use App\Models\AIModel;

class DownloadAIModel
{
    public function getAIModelAttributes(object $newVersionAIModel): array
    {
        return [
            'user_id'   => 1,
            'ai_file_id' => 1,
            'openai_id' => $newVersionAIModel->id,
            'type'      => ('currie'),
            'epochs'    => 0,
            'max_tokens' => 0,
            'temparture'   => 1
        ];
    }

    public function updateAIModelInDB(object $newVersionAIModel, AIModel $aiModel): void
    {
        $aiModel::where('openai_id',$newVersionAIModel->id)->update([
            'user_id'   => 1,
            'ai_file_id' => 1,
            'openai_id' => $newVersionAIModel->id,
            'type'      => ('currie'),
            'epochs'    => 0,
            'max_tokens' => 100,
            'temparture'   => 1
        ]);
        
    }
}