<?php

namespace App\Http\Controllers;

use App\Services\OpenAI\AIModel\AIModelDownloader;
use App\Services\OpenAI\AIModel\AIModelService;
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
}