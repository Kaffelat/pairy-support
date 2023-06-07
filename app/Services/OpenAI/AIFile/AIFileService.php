<?php
namespace App\Services\OpenAI\AIFile;

use App\Models\AIFile;
use Carbon\Carbon;
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
    public function uploadAFile(Client $client, Request $request): stdClass
    {
        $file = $request->file('file');
        
        $date = Carbon::now()->toDateString();
        
        $originalName = $file->getClientOriginalName();

        $filePath = $file->storeAs("public/UploadedFiles/Files:{$date}", "{$originalName}");
        
        try {
            $handle = fopen(storage_path("app/{$filePath}"), 'r');
        
            # Upload the file to the API using openai-php/client upload function
            $response = $client->files()->upload([
                'purpose' => 'fine-tune',
                'file' => $handle,
            ]);
            
            return (object)(array)$response;
        }
        catch (Exception $e) {
            Log::error("Couldn't upload file: \"{$file}\"");
            throw $e;
        }
    }

    /**
    * Deletes a file on your openai account
    */
    public function deleteAFile(String $openAIFileId): stdClass
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        $aiFile = AIFile::where('openai_id', $openAIFileId)->first();
        try {
            $aiFile->fineTuneJob->each(function ($fineTuneJob) {
                $fineTuneJob->ai_file_id = null;
                
                $fineTuneJob->update();
            });
            
            $aiFile->delete();
            
            $response = $client->files()->delete($openAIFileId);
            
            return (object)(array)$response; 
        }
        catch (Exception $e) {
            Log::error("Couldn't delete \"{$aiFile}\"");
            throw $e;
        }
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

}