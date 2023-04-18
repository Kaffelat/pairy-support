<?php
namespace App\Services\OpenAI\AIFile;

use OpenAI;

class UploadAIFiles
{
    protected $aiFileService;

    public function __construct(AIFileService $aiFileService)
    {
        $this->aiFileService = $aiFileService;
    }

    public function uploadAFile()
    {
        $yourApiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);

        return $this->aiFileService->uploadAFile($client,'/Users/ghf/pairy-support/app/Http/Controllers/test.jsonl');
    }

}