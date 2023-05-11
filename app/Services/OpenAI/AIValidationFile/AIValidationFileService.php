<?php
use stdClass;
use OpenAI\Client;

class AIValidationFileService {
    
    /**
    * Lists all the files that's on your OpenAI account
    */
    public function listAllFiles(Client $client): stdClass
    {
        $response = $client->files()->list();

        return (object)(array)$response; 
    }
}