<?php
namespace App\Services\OpenAI;

use App\Models\AIModelValidation;
use App\Services\OpenAI\AIFile\AIFileService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use OpenAI;

class AIModelValidationDownloader 
{
    protected $aiFileService;

    public function __construct(AIFileService $aiFileService)
    {
        $this->aiFileService = $aiFileService;
    }

    public function getAllValidationFiles(): Collection
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);
        
        $downloadAIModelValidation= new DownloadAIModelValidation;
        $aiModelValidation = new AIModelValidation;
        
        #For every file that's on the users account, look if it's already inside the database
        #If it is, update it else make a new$aiModelValidation in the database
        foreach ($this->aiFileService->listAllFiles($client)->data as $file) {
            try {
                if ($file->purpose == "fine-tune-results") { 
                    if ($aiModelValidation::where('openai_id',$file->id)->count() > 0) {
                        
                        $downloadAIModelValidation->updateAValidationFileInDB($file, $aiModelValidation);
                    }
                    else {
                        $aiModelValidation = new AIModelValidation;
                        
                        $aiModelValidation->fill($downloadAIModelValidation->getAIModelValidationFileAttributes($file));
                        
                        $aiModelValidation->save();
                    }
                }
            }
            catch (Exception $e) {
                throw $e;
            }
        }
        return$aiModelValidation::all();
    }
}