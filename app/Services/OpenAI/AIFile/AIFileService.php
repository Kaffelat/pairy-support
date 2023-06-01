<?php
namespace App\Services\OpenAI\AIFile;

use App\Models\AIFile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use OpenAI;
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
    
            return (object)(array)$response;
        }
        catch (Exception $e) {
            throw $e;
        }
    }

    /**
    * Deletes a file on your openai account
    */
    public function deleteAFile(String $openaiFileId): stdClass
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        $aiFile = AIFile::where('openai_id', $openaiFileId)->first();

        $aiFile->fineTuneJob->each(function ($fineTuneJob) {
            $fineTuneJob->ai_file_id = null;

            $fineTuneJob->update();
         });

        $aiFile->delete();

        $response = $client->files()->delete($openaiFileId);

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

    public function downloadFile(Client $client, String $fileId): stdClass
    {
        $response = $client->files()->download($fileId);

        return (object)(array)$response;
    }

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

}