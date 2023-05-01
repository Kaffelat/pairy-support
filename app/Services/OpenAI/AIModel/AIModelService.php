<?php
namespace App\Services\OpenAI\AIModel;

use OpenAI;
use OpenAI\Client;
use stdClass;

class AIModelService 
{
    /**
    * Makes a new Model in OpenAI
    */
    public function createNewModel(Client $client, String $traningFileId, String $validationFileId, String $modelType): stdClass
    {
        if ($validationFileId === true) { 
            $response = $client->fineTunes()->create([
                'training_file' => $traningFileId,
                'model' => $modelType,
                'n_epochs' => 4,
                'learning_rate_multiplier' => 0.2,
                'prompt_loss_weight' => 0.01,
            ]);
        }
        
        $response = $client->fineTunes()->create([
            'training_file' => $traningFileId,
            'model' => 'curie',
            'n_epochs' => 4,
            'learning_rate_multiplier' => 0.2,
            'prompt_loss_weight' => 0.01,
        ]);

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

    public function cancelJob(Client $client, String $jobId): stdClass
    {
        $response = $client->fineTunes()->cancel($jobId);

        return (object)(array)$response; 
    }

    /**
    * Lists all models on OpenAI
    */
    public function listAllModelsWithInfo(Client $client): stdClass
    {
        $response = $client->fineTunes()->list();
        
        return (object)(array)$response;
    }

    public function listAllModels(Client $client): stdClass
    {
        $response = $client->models()->list();
        
        $modelsByOwner = [];

        foreach ($response->data as $result) {

            if ($result->ownedBy == 'user-4s6uhvtyshm5qqxfhoa0xrtj') {
                array_push($modelsByOwner, $result);
            }
        }
        return (object)(array)$modelsByOwner;
    }

    /**
    * Gets a specific model
    */
    public function getAModel(Client $client, String $modelId): stdClass
    {
        $response = $client->models()->retrieve($modelId);

        return (object)(array)$response; 
    }

    public function getInfoAboutModel(Client $client, String $modelId): stdClass
    {
        $response = $client->fineTunes()->retrieve($modelId);

       return (object)(array)$response; 
    }
}
