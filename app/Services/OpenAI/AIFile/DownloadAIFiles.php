<?php
namespace App\Services\OpenAI\AIFile;

use stdClass;

class DownloadAIFIles
{

    public function getFileAttributes(stdClass $file): array
    {
        return [
            'openai_id' => $file->id,
            'user_id'   => 1,
            'data'      => ['test for nu'],
            'tokens'    => 0,
            'validering' => 0,
            'traning'   => 1
        ];
    }

}

