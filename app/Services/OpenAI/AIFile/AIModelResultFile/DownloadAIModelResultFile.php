<?php
namespace App\Services\OpenAI\AIFile\AIModelResultFile;

use App\Models\AIModelResultFile;

class DownloadAIModelResultFile
{
    public function GetAIModelResultFileAttributes(object $resultFile): array
    {
        return [
            'openai_id' => $resultFile->id,
            'byte_size' => $resultFile->bytes,
            'file_purpose' => $resultFile->purpose
        ];
    }

    
}