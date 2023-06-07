<?php
namespace App\Services\OpenAI\AIModelResultFile;

use App\Models\AIModelResultFile;
use App\Services\OpenAI\AIFile\AIFileService;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use OpenAI;
use stdClass;

class AIModelResultFileDownloader
{
    protected $aiModelResultFileService;

    public function __construct(AIModelResultFileService $aiModelResultFileService)
    {
        $this->aiModelResultFileService = $aiModelResultFileService;
    }

    /**
    * Gets all AIModelResultFiles on OpenAI's api
    */
    public function getAllModelResultFiles(): Collection
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);
        
        $downloadAIModelResult = new DownloadAIModelResultFile;
        
        foreach ($this->aiModelResultFileService->listAllFiles($client)->data as $file) {
            try {
                if ($file->purpose == 'fine-tune-results') {
                    
                    $aiModelResultFile = AIModelResultFile::firstOrCreate([
                        'openai_id' => $file->id
                    ]);
                    
                    $aiModelResultFile->fill($downloadAIModelResult->GetAIModelResultFileAttributes($file));
                    
                    $aiModelResultFile->save();
                }
                return AIModelResultFile::all();
            }
            catch (Exception $e) {
                Log::error("Failed to retrive file: \"{$file}\"");
                throw $e;
            }
        }
    }

    /**
    * Shows the content of a AIModelResultFile
    */
    public function downloadModelResultFile(string $resultFileId): array
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);
        
        try {
            $resultFileId = AIModelResultFile::where('id', $resultFileId)->first();

            return $this->aiModelResultFileService->downloadResultFile($client, $resultFileId->openai_id);
        }
        catch (Exception $e) {
            Log::error("Failed to download ResultFile: \"{$resultFileId}\"");
            throw $e;
        }
    }

    /**
    * Gets the attributes, like purpose and bite size, for a single AIModelResultFile
    */
    public function getModelResultFile(string $resultFileId): stdClass
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        try {
            $resultFileId = AIModelResultFile::where('id', $resultFileId)->first();
            
            return $this->aiModelResultFileService->getAFile($client, $resultFileId->openai_id);
        }
        catch (Exception $e) {
            Log::error("Failed to get ResultFile: \"{$resultFileId}\"");
            throw $e;
        }
    }

    /**
    * Retrives a single AIModelResultFile from OpenAI and then updates or creates a new resultFile in the db
    * Gets used in FineTuneJobDownloader
    */
    public function makeAModelResultFile(string $resultFileId): AIModelResultFile
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);
        
        $downloadAIModelResult = new DownloadAIModelResultFile;
        
        try {
            $resultFile = $this->aiModelResultFileService->getAFile($client, $resultFileId);
            
            $newResultFile = AIModelResultFile::firstOrCreate([
                'openai_id' => $resultFile->id,
            ]);
            
            $newResultFile->fill($downloadAIModelResult->getAIModelResultFileAttributes($resultFile));
            
            $newResultFile->save();
            
            return $newResultFile;
        }
        catch (Exception $e) {
            Log::error("Failed to make a new ModelResultFile: \"{$resultFile}\"");
            throw $e;
        }
    }
}