<?php
namespace App\Services\OpenAI;

use OpenAI;

class AIModel 
{
    /**
    * Makes a new Model in OpenAI
    */
    public function makeNewModel($client ,$traningFileId, $validationFileId, $modelType): array
    {
        $myAPIKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($myAPIKey);

        if ($validationFileId === TRUE) { 
            $response = $client->fineTunes()->create([
                'training_file' => $traningFileId,
                'validation_file' => $validationFileId,
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

        $response->id;
        $response->object; 

        return $response->toArray();
    }

    /**
    * Deletes a model 
    */
    public function deleteModel($client, $modelId): array
    {
        $myAPIKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($myAPIKey);

        $response = $client->models()->delete($modelId);

        $response->id; 
        $response->object; 
        $response->deleted; 

        return $response->toArray();
    }

    /**
    * Lists all models on OpenAI
    */
    public function listModels($client): array
    {
        $response = $client->models()->list();

        $response->object; 

        foreach ($response->data as $result) {
            $result->id; 
            $result->object; 
            
        }

        return $response->toArray(); 
    }

    /**
    * Gets a specific model
    */
    public function getASpecificModel($client): array
    {
        $response = $client->models()->retrieve('text-davinci-003');

        $response->id; // 'text-davinci-003'
        $response->object; // 'model'
        $response->created; // 1642018370
        $response->ownedBy; // 'openai'
        $response->root; // 'text-davinci-003'
        $response->parent; // null

        foreach ($response->permission as $result) {
            $result->id; // 'modelperm-7E53j9OtnMZggjqlwMxW4QG7' 
            $result->object; // 'model_permission' 
            $result->created; // 1664307523 
            $result->allowCreateEngine; // false 
            $result->allowSampling; // true 
            $result->allowLogprobs; // true 
            $result->allowSearchIndices; // false 
            $result->allowView; // true 
            $result->allowFineTuning; // false 
            $result->organization; // '*' 
            $result->group; // null 
            $result->isBlocking; // false 
        }

        return $response->toArray(); 
    }
}
