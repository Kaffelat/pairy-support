<?php
namespace App\Services\OpenAI;

class AIModelData
{
    /**
    * Makes a new Model in OpenAI
    */
    public function uploadAFile($client, $filePath): array
    {
        $response = $client->files()->upload([
            'purpose' => 'fine-tune',
            'file' => fopen($filePath, 'r'),
        ]);
        
        $response->id; // 'file-XjGxS3KTG0uNmNOK362iJua3'
        $response->object; // 'file'
        $response->bytes; // 140
        $response->createdAt; // 1613779657
        $response->filename; // 'mydata.jsonl'
        $response->purpose; // 'fine-tune'
        $response->status; // 'succeeded'
        $response->status_details; // null

        fclose($response);

        return $response->toArray(); 
    }

    /**
    * Makes a new Model in OpenAI
    */
    public function deleteAFile($client, $fileId): array
    {
        $response = $client->files()->delete($fileId);

        $response->id; // 'file-XjGxS3KTG0uNmNOK362iJua3'
        $response->object; // 'file'
        $response->deleted; // true

        return $response->toArray(); 
    }

    /**
    * Makes a new Model in OpenAI
    */
    public function listAllFiles($client): array
    {
        $response = $client->files()->list();

        $response->object; // 'list'

        foreach ($response->data as $result) {
            $result->id; // 'file-XjGxS3KTG0uNmNOK362iJua3'
            $result->object; // 'file'
            // ...
        }

        return $response->toArray(); 
    }

    public function getAFile($client, $fileId): array
    {
        $response = $client->files()->retrieve('file-eFIFEp23oMQuDJ3d6kR58J9i');

        $response->id; // 'file-eFIFEp23oMQuDJ3d6kR58J9i'
        $response->object; // 'file'
        $response->bytes; // 140
        $response->createdAt; // 1613779657
        $response->filename; // 'mydata.jsonl'
        $response->purpose; // 'fine-tune'
        $response->status; // 'succeeded'
        $response->status_details; // null

        return $response->toArray(); // ['id' => 'file-eFIFEp23oMQuDJ3d6kR58J9i', ...]
    }
}