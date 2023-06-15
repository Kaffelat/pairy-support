<?php
namespace App\Services\OpenAI\AIModel;

use App\Models\AIModel;
use App\Models\AIModelResultFile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use OpenAI;
use OpenAI\Client;
use stdClass;

class AIModelService 
{
    /**
    * Makes a new Model on OpenAI
    */
    public function createOrTrainModel(Client $client, Request $request): stdClass
    {
        try {
            if ($request->validationFile != null) { 
                $response = $client->fineTunes()->create([
                    'training_file' => $request->traningFile,
                    'validation_file' => $request->validationFile,
                    'model' => $request->type,
                    'n_epochs' => $request->epochs,
                    'learning_rate_multiplier' => $request->learningRate,
                    'prompt_loss_weight' => $request->promptLoss,
                ]);
            }
            $response = $client->fineTunes()->create([
                'training_file' => $request->traningFile,
                'model' => $request->type,
                'n_epochs' => $request->epochs,
                'learning_rate_multiplier' => $request->learningRate,
                'prompt_loss_weight' => $request->promptLoss,
            ]);
            
            return (object)(array)$response; 
        }

        catch (Exception $e) {
            Log::error("Couldn't train new model");
            throw $e;
        }
    }

    /**
    * Deletes a model, all the FIneTuneJobs that are associated and the AIModelResultFile that matches that job
    */
    public function deleteModel(string $openAIModelId): stdClass
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        try {
            $aiModel = AIModel::where('openai_id', $openAIModelId)->first();
            
            $aiModel->fineTuneJob->each(function ($fineTuneJob) {
                $fineTuneJob->delete();
                
                AIModelResultFile::where('id', $fineTuneJob->ai_model_result_file_id)->delete();
            });
            
            $aiModel->delete();
            
            $response = $client->models()->delete($openAIModelId);
            
            return (object)(array)$response;
        }

        catch (Exception $e) {
            Log::error("Failed to delete \"{$aiModel}\"");
            throw $e;
        }
    }

    /**
    * Lists all models that a user has made on OpenAI
    */
    public function listAllModels(Client $client): stdClass
    {
        $response = $client->models()->list();

        $modelsByOwner = [];

        try {
            foreach ($response->data as $result) {
                if ($result->ownedBy != 'openai' && $result->ownedBy != 'openai-dev' && $result->ownedBy != 'openai-internal' && $result->ownedBy != 'system') {
                    array_push($modelsByOwner, $result);
                }
            }
            return (object)(array)$modelsByOwner;
        }
        catch (Exception $e) {
            Log::error("Couldn't retrive models");
            throw $e;
        }
    }

    /**
    * Gets a specific model from OpenAI
    */
    public function getAModel(Client $client, string $modelId): stdClass
    {
        $response = $client->models()->retrieve($modelId);

        return (object)(array)$response;
    }
}
