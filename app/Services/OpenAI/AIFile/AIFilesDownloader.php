<?php
namespace App\Services\OpenAI\AIFile;

use App\Models\AIFile;

use App\Models\AIModelResultFile;
use App\Services\OpenAI\AIFile\AIModelResultFile\DownloadAIModelResultFile;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use OpenAI;
use stdClass;

class AIFilesDownloader
{   
    protected $aiFileService;

    public function __construct(AIFileService $aiFileService)
    {
        $this->aiFileService = $aiFileService;
    }
    
    /**
    * Gets all files on OpenAI's api 
    */
    public function getAllFiles(): Collection
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);
        
        $downloadAIFile = new DownloadAIFiles;
        
        #For every file that's on the users account look if it's already inside the database
        #If it is update it else make a new AIFile in the database

        foreach ($this->aiFileService->listAllFiles($client)->data as $file) {
            try {
                if ($file->purpose != "fine-tune-results") { 

                    $aiFile = AIFile::firstOrCreate([
                        'openai_id' => $file->id,
                        'user_id' => Auth::user()->id,
                    ]);
                    
                    $aiFile->fill($downloadAIFile->getFileAttributes($file));
                    
                    $aiFile->save();
                }
            }
            catch (Exception $e) {
                throw $e;
            }
        }
        return AIFile::all();
    }

    #Gets a single file by using it's OpenAI id
    public function getAFile(): stdClass
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        return $this->aiFileService->getAFile($client, 'file-c3noJiDFH6ZjIHsSfsO0EiKm');
    }
    
    public function test(): stdClass
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        return $this->aiFileService->getOneAFile($client, 'file-c3noJiDFH6ZjIHsSfsO0EiKm');
    }
}
