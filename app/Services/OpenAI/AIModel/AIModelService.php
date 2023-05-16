<?php
namespace App\Services\OpenAI\AIModel;

use Exception;
use Illuminate\Http\Request;
use OpenAI\Client;
use stdClass;

class AIModelService 
{
    /**
    * Makes a new Model in OpenAI
    */
    public function createNewModel(Client $client, Request $request): stdClass
    {
        $response = $client->fineTunes()->create([
            'training_file' => $request->traningFile,
            'model' => $request->type,
            'n_epochs' => 4,
            'learning_rate_multiplier' => 0.2,
            'prompt_loss_weight' => 0.01,
        ]);

        // if ($request->validationFile == true) { 
        //     $response = $client->fineTunes()->create([
        //         'training_file' => $request->traningFile,
        //         'model' => $request->type,
        //         'n_epochs' => 4,
        //         'learning_rate_multiplier' => 0.2,
        //         'prompt_loss_weight' => 0.01,
        //     ]);
        // }
        
        return (object)(array)$response; 
    }

    /**
    * Deletes a model 
    */
    public function deleteModel(Client $client, String $modelId): stdClass
    {
        $response = $client->models()->delete($modelId);

        return (object)(array)$response; 
    }

    /**
    * Cancels the creation of a model
    */
    public function cancelJob(Client $client, String $jobId): stdClass
    {
        $response = $client->fineTunes()->cancel($jobId);

        return (object)(array)$response; 
    }

    /**
    * Lists all models on OpenAI
    */
    public function listAllFineTuneJobs(Client $client): stdClass
    {
        $response = $client->fineTunes()->list();
        
        return (object)(array)$response;
    }

    /**
    * Lists all models that you have made on OpenAI
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
        }
        catch (Exception $e) {
            throw $e;
        }
        return (object)(array)$modelsByOwner;
    }

    /**
    * Gets a specific model
    */
    public function getAModel(Client $client, String $modelId): stdClass
    {
        try {
            $response = $client->models()->retrieve($modelId);
        } 
        catch (Exception $e) {
            throw $e;
        }
        return (object)(array)$response;
    }

    /**
    * Deletes a model 
    */
    public function getAModelsFineTuneJobs(Client $client, String $openAIModelId): stdClass
    {
        try {
            $response = $client->fineTunes()->retrieve($openAIModelId);
        }
        catch (Exception $e) {
            throw $e;
        }
        return (object)(array)$response;
    }
}
