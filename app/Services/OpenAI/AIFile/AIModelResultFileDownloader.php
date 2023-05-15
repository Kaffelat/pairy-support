<?php
namespace App\Services\OpenAI\AIFile;

use App\Models\AIModelResultFile;
use App\Services\OpenAI\AIFile\AIFileService;
use App\Services\OpenAI\AIFile\DownloadAIModelResultFile;
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
}