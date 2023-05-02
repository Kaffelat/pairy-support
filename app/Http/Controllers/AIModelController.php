<?php

namespace App\Http\Controllers;

use App\Models\AIModel;
use App\Services\OpenAI\AIModel\AIModelDownloader;
use App\Services\OpenAI\AIModel\AIModelService;
use App\Services\OpenAI\AIModel\UploadAIModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenAI;

class AIModelController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

   public function getAllModels(AIModelService $aiModelService): Collection
   {
    $aiModelDownloader = new AIModelDownloader($aiModelService);

    return $aiModelDownloader->getAIModels();
   }

   public function makeModel(AIModelService $aiModelService): object
   {
    $aiModelUploader = new UploadAIModel($aiModelService);

    return $aiModelUploader->makeAIModel();
   }

   public function getModel(AIModelService $aiModelService): object
   {
    $aiModelDownloader = new AIModelDownloader($aiModelService);

    return $aiModelDownloader->getModelById();
   }

   public function getInfoAboutModel(AIModelService $aiModelService): object
   {
    $aiModelDownloader = new AIModelDownloader($aiModelService);

    return $aiModelDownloader->getInfoAboutModel();
   }

   public function deleteModel(AIModelService $aiModelService): object
    {
        $yourApiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);

        $modelId = 'curie:ft-personal-2023-04-12-07-49-47';

        AIModel::where('openai_id', $modelId)->delete();

        return $aiModelService->deleteModel($client, $modelId);
    }
}