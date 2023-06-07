<?php
namespace App\Services\OpenAI\AIModelResultFile;

use OpenAI\Client;
use stdClass;

class AIModelResultFileService
{
    public function downloadResultFile(Client $client, String $fileId): array
    {
        $response = $client->files()->download($fileId);

        $lines = explode("\n", $response);
        $data = [];
        
        for ($i = 1; $i < count($lines)-1; $i++) {
            $values = explode(',', $lines[$i]);
            array_push($data, $values);
        }
        
        return $data;
    }

    /**
    * Gets a single file from your OpenAI account
    */
    public function getAFile(Client $client, String $fileId): stdClass
    {
        $response = $client->files()->retrieve($fileId);

        return (object)(array)$response;
    }

     /**
    * Lists all the files that's on your OpenAI account
    */
    public function listAllFiles(Client $client): stdClass
    {
        $response = $client->files()->list();

        return (object)(array)$response; 
    }
}