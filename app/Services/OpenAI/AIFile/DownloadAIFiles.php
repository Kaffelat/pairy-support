<?php
namespace App\Services\OpenAI\AIFile;

use App\Models\AIFile;
use Illuminate\Support\Facades\Auth;
use stdClass;

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

