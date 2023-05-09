<?php
namespace App\Services\OpenAI\AIFile;

use Illuminate\Http\Request;
use OpenAI;

class UploadAIFiles
{
    protected $aiFileService;

    public function __construct(AIFileService $aiFileService)
    {
        $this->aiFileService = $aiFileService;
    }

    public function uploadAFile(Request $request): object
    {
        $yourApiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);

        return $this->aiFileService->uploadAFile($client,$request);
    }

}