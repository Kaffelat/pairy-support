<?php
namespace App\Services\OpenAI\AIFile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $client = OpenAI::client(Auth::user()->openai_api_key);

        return $this->aiFileService->uploadAFile($client,$request);
    }

}