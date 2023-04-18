<?php
namespace App\Services\OpenAI\AIFile;

use OpenAI\Client;
use stdClass;

class AIFileService
{
    /**
    * Makes a new Model in OpenAI
    */
    public function uploadAFile(Client $client, String $filePath, String $purpose): stdClass
    {
        $response = $client->files()->upload([
            'purpose' => $purpose,
            'file' => fopen($filePath, 'r'),
        ]);
        
        $response->id; // 'file-XjGxS3KTG0uNmNOK362iJua3'
        $response->object; // 'file'
        $response->bytes; // 140
        $response->createdAt; // 1613779657
        $response->filename; // 'mydata.jsonl'
        $response->purpose; // 'fine-tune'
        $response->status; // 'succeeded'

        fclose($response);

        return (object)(array)$response; 
    }

    /**
    * Makes a new Model in OpenAI
    */
    public function deleteAFile(Client $client, String $fileId): stdClass
    {
        $response = $client->files()->delete($fileId);

        $response->id; // 'file-XjGxS3KTG0uNmNOK362iJua3'
        $response->object; // 'file'
        $response->deleted; // true

        return (object)(array)$response; 
    }

    /**
    * Makes a new Model in OpenAI
    */
    public function listAllFiles(Client $client): stdClass
    {
        $response = $client->files()->list();

        $response->object; // 'list'

        foreach ($response->data as $result) {
            $result->id; // 'file-XjGxS3KTG0uNmNOK362iJua3'
            $result->object; // 'file'
            // ...
        }

        return (object)(array)$response; 
    }

    public function getAFile(Client $client, String $fileId): stdClass
    {
        $response = $client->files()->retrieve($fileId);

        $response->id; // 'file-eFIFEp23oMQuDJ3d6kR58J9i'
        $response->bytes; // 140
        $response->createdAt; // 1613779657
        $response->filename; // 'mydata.jsonl'
        $response->purpose; // 'fine-tune'
        $response->status; // 'succeeded'

        return (object)(array)$response;  // ['id' => 'file-eFIFEp23oMQuDJ3d6kR58J9i', ...]
    }
}