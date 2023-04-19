<?php
namespace App\Services\OpenAI\AIFile;

use OpenAI\Client;
use stdClass;

class AIFileService
{
    /**
    * Makes a new Model in OpenAI
    */
    public function uploadAFile(Client $client, String $filePath): stdClass
    {
        $response = $client->files()->upload([
            'purpose' => 'fine-tune',
            'file' => fopen($filePath, 'r'),
        ]);

        return (object)(array)$response; 
    }

    /**
    * Makes a new Model in OpenAI
    */
    public function deleteAFile(Client $client, String $fileId): stdClass
    {
        $response = $client->files()->delete($fileId);

        return (object)(array)$response; 
    }

    /**
    * Makes a new Model in OpenAI
    */
    public function listAllFiles(Client $client): stdClass
    {
        $response = $client->files()->list();

        return (object)(array)$response; 
    }

    public function getAFile(Client $client, String $fileId): stdClass
    {
        $response = $client->files()->retrieve($fileId);

        return (object)(array)$response;  // ['id' => 'file-eFIFEp23oMQuDJ3d6kR58J9i', ...]
    }

    public function getInfoAboutAFile(Client $client, String $fileId): stdClass
    {
        return (object)(array)$client->files()->download($fileId);
    }
}