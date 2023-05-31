<?php
namespace App\Services\OpenAI\AIModelResultFile;

class DownloadAIModelResultFile
{
    /**
    * Set the attributes of a AIModelResultFile
    */
    public function GetAIModelResultFileAttributes(object $resultFile): array
    {
        return [
            'byte_size' => $resultFile->bytes,
            'file_purpose' => $resultFile->purpose
        ];
    }
}