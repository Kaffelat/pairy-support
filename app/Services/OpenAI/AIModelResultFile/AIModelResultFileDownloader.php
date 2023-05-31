<?php
namespace App\Services\OpenAI\AIModelResultFile;

use App\Models\AIModelResultFile;
use App\Services\OpenAI\AIFile\AIFileService;
use Illuminate\Support\Facades\Auth;
use OpenAI;

class AIModelResultFileDownloader
{
    protected $aiFileService;

    public function __construct(AIFileService $aiFileService)
    {
        $this->aiFileService = $aiFileService;
    }

    public function getAllModelResultFiles()
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

    public function downloadModelResultFile(string $resultFileId)
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        $resultFileId = AIModelResultFile::where('id', $resultFileId)->first();

        return $this->aiFileService->downloadResultFile($client, $resultFileId->openai_id);
    }

    public function getModelResultFile(string $resultFileId)
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        $resultFileId = AIModelResultFile::where('id', $resultFileId)->first();

        return $this->aiFileService->getAFile($client, $resultFileId->openai_id);
    }

    public function makeAModelResultFile(string $resultFileId)
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