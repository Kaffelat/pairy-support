<?php

namespace App\Http\Controllers;

use App\Services\OpenAI\AIModel\AIModelDownloader;
use App\Services\OpenAI\AIModel\AIModelService;
use App\Services\OpenAI\AIModel\UploadAIModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use stdClass;

class AIModelController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
    * Downloads all models that the user has made on OpenAI
    */
    public function getAllModels(AIModelService $aiModelService): Collection
    {
        $aiModelDownloader = new AIModelDownloader($aiModelService);

        return $aiModelDownloader->getAIModels();
    }

    /**
    * Makes a new Model
    */
    public function createOrTrainModel(Request $request, AIModelService $aiModelService): stdClass
    {
        $aiModelUploader = new UploadAIModel($aiModelService);

        return $aiModelUploader->createOrTrainModel($request);
    }

    /**
    * Gets a single model 
    */
    public function getModel(AIModelService $aiModelService): stdClass
    {
        $aiModelDownloader = new AIModelDownloader($aiModelService);

        return $aiModelDownloader->getModelById();
    }

    /**
    * Deletes a model 
    */
    public function deleteModel(String $openaiModelId, AIModelService $aiModelService): stdClass
    {   
       return $aiModelService->deleteModel($openaiModelId);
    }
}