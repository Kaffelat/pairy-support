<?php
namespace App\Services\OpenAI\AIFile;

class DownloadAIFiles
{
    /**
     * Sets the attributes of a file
     */
    public function getFileAttributes(object $file): array
    {
        return [
            'name'      => $file->filename,
            'byte_size' => $file->bytes,
            'file_purpose' => $file->purpose
        ];
    }

}

