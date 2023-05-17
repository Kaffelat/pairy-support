<?php
namespace App\Services\OpenAI\AIFile;

class DownloadAIFiles
{

    public function getFileAttributes(object $file): array
    {
        return [
            'name'      => $file->filename,
            'byte_size' => $file->bytes,
            'file_purpose' => $file->purpose
        ];
    }

}

