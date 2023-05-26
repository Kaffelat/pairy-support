<?php
namespace App\Services\OpenAI\AIModelResultFile;

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