<?php
namespace App\Services\OpenAI\AIModel;

class DownloadAIModel
{
    public function getAIModelAttributes(object $openAIModel): array
    {
        return [
            'type' => $this->getModelType($openAIModel),
        ];
    }

    public function getModelType(object $openAIModel): string
    {
        $id = $openAIModel->id;

        $exploded = explode(":", $id);

        return $exploded[0];
    }

}