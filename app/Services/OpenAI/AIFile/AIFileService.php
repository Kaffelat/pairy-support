<?php
namespace App\Services\OpenAI\AIFile;

use Exception;
use Illuminate\Http\Request;
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

        try {
            $handle = fopen($file->getPathname(), 'r');

            #Checks if the file can be read 
            if (fread($handle, 1) === false) {

                fclose($handle);
                
                return null;
            }
            #Rewinds the file pointer so we doesn't skip the first letter 
            rewind($handle);

            # Upload the file to the API using openai-php/client upload function
            $response = $client->files()->upload([
                'purpose' => 'fine-tune',
                'file' => $handle,
            ]);
    
        }
        catch (Exception $e) {
            throw $e;
        }
        return (object)(array)$response;
    }

    /**
    * Deletes a file on your openai account
    */
    public function deleteAFile(Client $client, String $fileId): stdClass
    {
        $response = $client->files()->delete($fileId);

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

    /**
    * Gets a single file from your OpenAI account
    */
    public function getAFile(Client $client, String $fileId): stdClass
    {
        $response = $client->files()->retrieve($fileId);

        return (object)(array)$response;
    }

}