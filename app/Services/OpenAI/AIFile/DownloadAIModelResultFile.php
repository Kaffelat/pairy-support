<?php
namespace App\Services\OpenAI\AIFile;

class DownloadAIModelResultFile
{
    public function GetAIModelResultFileAttributes(object $resultFile): array
    {
        return [
            'byte_size' => $resultFile->bytes,
            'file_purpose' => $resultFile->purpose
        ];
    }

    
}