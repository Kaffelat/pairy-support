<?php
namespace App\Services\OpenAI\AIFile;

use App\Models\AIFile;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use OpenAI;

class AIFilesDownloader
{   
    protected $aiFileService;

    public function __construct(AIFileService $aiFileService)
    {
        $this->aiFileService = $aiFileService;
    }
    
    /**
    * Gets all files that, the user has uploaded, on OpenAI's api 
    */
    public function getAllFiles(): Collection
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);
        
        $downloadAIFile = new DownloadAIFiles;
        
        $userId = Auth::user()->id;

        #For every file that's on the users account look if it's already inside the database
        #If it is update it else make a new AIFile in the database
        foreach ($this->aiFileService->listAllFiles($client)->data as $file) {
            try {
                if ($file->purpose != "fine-tune-results") { 

                    $aiFile = AIFile::firstOrCreate([
                        'openai_id' => $file->id,
                        'user_id' => $userId,
                    ]);
                    
                    $aiFile->fill($downloadAIFile->getFileAttributes($file));
                    
                    $aiFile->save();
                }
            }
            catch (Exception $e) {
                Log::error("Could retrive file: \"{$file}\"");
                throw $e;
            }
        }
        return AIFile::where('user_id', $userId)->get();
    }
}
