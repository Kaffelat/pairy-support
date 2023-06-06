<?php 
namespace App\Services\OpenAI\FineTuneJob;

use OpenAI\Client;
use stdClass;

class FineTuneJobService
{
    /**
     * Gets a the FineTuneJobs that for a AIModel
     */
    public function getAModelsFineTuneJobs(Client $client, string $openAIModelId): stdClass
    {
        $response = $client->fineTunes()->retrieve($openAIModelId);
      
        return (object)(array)$response;
    }

    /**
    * Lists all FineTuneJobs on OpenAI
    */
    public function listAllFineTuneJobs(Client $client): stdClass
    {
        $response = $client->fineTunes()->list();
        
        return (object)(array)$response;
    }

}
