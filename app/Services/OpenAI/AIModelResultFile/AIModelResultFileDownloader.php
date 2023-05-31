<?php
namespace App\Services\OpenAI\AIModelResultFile;

use App\Models\AIModelResultFile;
use App\Services\OpenAI\AIFile\AIFileService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use OpenAI;
use stdClass;

class AIModelResultFileDownloader
{
    protected $aiFileService;

    public function __construct(AIFileService $aiFileService)
    {
        $this->aiFileService = $aiFileService;
    }

    /**
    * Gets all AIModelResultFiles on OpenAI's api
    */
    public function getAllModelResultFiles(): Collection
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);
        
        $downloadAIModelResult = new DownloadAIModelResultFile;

        foreach ($this->aiFileService->listAllFiles($client)->data as $file) {
            if ($file->purpose == 'fine-tune-results') {
                
                $aiModelResultFile = AIModelResultFile::firstOrCreate([
                    'openai_id' => $file->id
                ]);
                
                $aiModelResultFile->fill($downloadAIModelResult->GetAIModelResultFileAttributes($file));
                
                $aiModelResultFile->save();
            }
        }
        return AIModelResultFile::all();
    }

    /**
    * Shows the content of a AIModelResultFile
    */
    public function downloadModelResultFile(string $resultFileId): array
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        $resultFileId = AIModelResultFile::where('id', $resultFileId)->first();

        return $this->aiFileService->downloadResultFile($client, $resultFileId->openai_id);
    }

    /**
    * Gets the attributes of a single AIModelResultFile
    */
    public function getModelResultFile(string $resultFileId): stdClass
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        $resultFileId = AIModelResultFile::where('id', $resultFileId)->first();

        return $this->aiFileService->getAFile($client, $resultFileId->openai_id);
    }

    /**
    * Retrives a single AIModelResultFile from OpenAI and then updates or creates a new resultFile in the db
    * Gets used in FineTuneJobDownloader
    */
    public function makeAModelResultFile(string $resultFileId): AIModelResultFile
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);
        $downloadAIModelResult = new DownloadAIModelResultFile;

        $resultFile = $this->aiFileService->getAFile($client, $resultFileId);

        $newResultFile = AIModelResultFile::firstOrCreate([
            'openai_id' => $resultFile->id,
        ]);

        $newResultFile->fill($downloadAIModelResult->GetAIModelResultFileAttributes($resultFile));
                
        $newResultFile->save();

        return $newResultFile;
    }
}