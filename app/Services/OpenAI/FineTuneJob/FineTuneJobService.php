<?php 
namespace App\Services\OpenAI\FineTuneJob;

use OpenAI\Client;
use stdClass;

class FineTuneJobService
{
    public function getAModelsFineTuneJobs(Client $client, string $openAIModelId): stdClass
    {
        $response = $client->fineTunes()->retrieve($openAIModelId);
      
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

}
