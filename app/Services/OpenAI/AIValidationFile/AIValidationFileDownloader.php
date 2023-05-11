<?php
namespace App\Services\OpenAI;

use App\Models\AIModelValidation;
use App\Models\AIValidationFile;
use App\Services\OpenAI\AIFile\AIFileService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use OpenAI;

class AIValidationFileDownloader 
{
    protected $aiFileService;

    public function __construct(AIFileService $aiFileService)
    {
        $this->aiFileService = $aiFileService;
    }

    public function getAllValidationFiles(): Collection
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);
        
        $downloadAIValidationFile = new DownloadAIValidationFile;
        $aiValidationFile = new AIValidationFile;
        
        #For every file that's on the users account, look if it's already inside the database
        #If it is, update it else make a new$aiValidationFile in the database
        foreach ($this->aiFileService->listAllFiles($client)->data as $file) {
            try {
                if ($file->purpose == "fine-tune-results") { 
                    if ($aiValidationFile::where('openai_id',$file->id)->count() > 0) {
                        
                        $downloadAIValidationFile->updateAValidationFileInDB($file, $aiValidationFile);
                    }
                    else {
                        $aiValidationFile = new AIValidationFile;
                        
                        $aiValidationFile->fill($downloadAIValidationFile->getAIValidationFileAttributes($file));
                        
                        $aiValidationFile->save();
                    }
                }
            }
            catch (Exception $e) {
                throw $e;
            }
        }
        return AIValidationFile::all();
    }
}