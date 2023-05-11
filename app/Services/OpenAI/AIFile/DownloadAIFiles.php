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
            'openai_id' => $file->id,
            'user_id'   => Auth::user()->id,
            'name'      => $file->filename,
            'byte_size' => $file->bytes,
            'file_purpose' => $file->purpose
        ];
    }

    public function updateAFileInDB(object $file, AIFile $aiFile): void
    {
        $aiFile::where('openai_id',$file->id)->update([ 
            'openai_id' => $file->id,
            'user_id'   => Auth::user()->id,
            'name'      => $file->filename,
            'byte_size' => $file->bytes,
            'data'      => json_encode(['test for nu']),
            'tokens'    => 0,
            'validering' => 0,
            'traning'   => 1,
            'file_purpose' => $file->purpose
        ]);
        
    }

}

