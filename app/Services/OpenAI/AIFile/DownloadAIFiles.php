<?php
namespace App\Services\OpenAI\AIFile;

use App\Models\AIFile;
use stdClass;

class DownloadAIFiles
{

    public function getFileAttributes(object $file): array
    {
        return [
            'openai_id' => $file->id,
            'user_id'   => 1,
            'data'      => json_encode(['test for nu']),
            'tokens'    => 0,
            'validering' => 0,
            'traning'   => 1
        ];
    }

    public function updateAFileInDB(object $file, AIFile $aiFile): void
    {
        $aiFile::where('openai_id',$file->id)->update([ 
            'openai_id' => $file->id,
            'user_id'   => 1,
            'data'      => json_encode(['test for nu22']),
            'tokens'    => 0,
            'validering' => 0,
            'traning'   => 1
            ]);
        
    }

}

