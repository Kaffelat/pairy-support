<?php
namespace App\Services\OpenAI\AIFile;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use OpenAI\Client;
use stdClass;

class AIFileService
{
    /**
    * Uploads a file to OpenAI
    */
    public function uploadAFile(Client $client, Request $request): mixed
    {
        $file = $request->file('file');
    
        $handle = fopen($file->getPathname(), 'r');

        if (fread($handle, 1) === false) {

            fclose($handle);
            return null;

        } 
        else {
            rewind($handle);
        }
    
        // Upload the file to the API using the file handle
        $response = $client->files()->upload([
            'purpose' => 'fine-tune',
            'file' => $handle,
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