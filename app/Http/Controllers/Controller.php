<?php

namespace App\Http\Controllers;

use App\Models\AIModel;
use App\Services\OpenAI\AIFile\UploadAIFiles;
use App\Services\OpenAI\AIModel\AIModelDownloader;
use App\Services\OpenAI\AIModel\AIModelService;
use App\Services\OpenAI\AIModel\UploadAIModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenAI;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

   public function getAllModels(AIModelService $aiModelService)
   {
    $aiModelDownloader = new AIModelDownloader($aiModelService);

    return $aiModelDownloader->getAIModels();
   }

   public function makeModel(AIModelService $aiModelService)
   {
    $aiModelUploader = new UploadAIModel($aiModelService);

    return $aiModelUploader->makeAIModel();
   }

   public function getModel(AIModelService $aiModelService)
   {
    $aiModelDownloader = new AIModelDownloader($aiModelService);

    return $aiModelDownloader->getModelById();
   }

   public function getInfoAboutModel(AIModelService $aiModelService)
   {
    $aiModelDownloader = new AIModelDownloader($aiModelService);

    return $aiModelDownloader->getInfoAboutModel();
   }

   public function deleteModel(AIModelService $aiModelService)
    {
        $yourApiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);

        $modelId = 'curie:ft-personal-2023-04-12-07-49-47';

        AIModel::where('openai_id', $modelId)->delete();

        return $aiModelService->deleteModel($client, $modelId);
    }
}