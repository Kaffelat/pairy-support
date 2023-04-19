<?php

namespace App\Http\Controllers;

use App\Services\OpenAI\AIFile\UploadAIFiles;
use App\Services\OpenAI\AIModel\AIModelDownloader;
use App\Services\OpenAI\AIModel\AIModelService;
use App\Services\OpenAI\AIModel\UploadAIModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

   public function getAllFinetuneModels(AIModelService $aiModelService)
   {
    $aiModelDownloader = new AIModelDownloader($aiModelService);

    return $aiModelDownloader->getAllAIModels();
   }

   public function makeNewFinetuneModel(AIModelService $aiModelService)
   {
    $aiModelUploader = new UploadAIModel($aiModelService);

    return $aiModelUploader->makeNewAIModel();
   }

}