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
use Illuminate\Support\Facades\Auth;
use OpenAI;
use stdClass;

class AIModelController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getAllModels(AIModelService $aiModelService): Collection
    {
        $aiModelDownloader = new AIModelDownloader($aiModelService);

        return $aiModelDownloader->getAIModels();
    }

    public function makeAIModel(Request $request ,AIModelService $aiModelService): stdClass
    {
        $aiModelUploader = new UploadAIModel($aiModelService);

        return $aiModelUploader->makeAIModel($request);
    }

    public function getModel(AIModelService $aiModelService): stdClass
    {
        $aiModelDownloader = new AIModelDownloader($aiModelService);

        return $aiModelDownloader->getModelById();
    }

    public function getInfoAboutModel(AIModelService $aiModelService): stdClass
    {
        $aiModelDownloader = new AIModelDownloader($aiModelService);

        return $aiModelDownloader->getInfoAboutModel();
    }

    public function deleteModel($openaiModelId, AIModelService $aiModelService): stdClass
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        AIModel::where('openai_id', $openaiModelId)->delete();

        return $aiModelService->deleteModel($client, $openaiModelId);
    }
}