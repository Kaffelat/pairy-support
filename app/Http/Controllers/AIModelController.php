<?php

namespace App\Http\Controllers;

use App\Models\AIModel;
use App\Services\OpenAI\AIModel\AIModelDownloader;
use App\Services\OpenAI\AIModel\AIModelService;
use App\Services\OpenAI\AIModel\UploadAIModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
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

    public function makeAIModel(Request $request ,AIModelService $aiModelService): object
    {
        $aiModelUploader = new UploadAIModel($aiModelService);

        return $aiModelUploader->makeAIModel($request);
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

    public function deleteModel($openaiModelId, AIModelService $aiModelService): object
    {
        $yourApiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);

        AIModel::where('openai_id', $openaiModelId)->delete();

        return $aiModelService->deleteModel($client, $openaiModelId);
    }
}