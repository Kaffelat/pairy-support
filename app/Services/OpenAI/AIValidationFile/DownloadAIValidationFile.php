<?php
namespace App\Services\OpenAI;

use App\Models\AIValidationFile;
use Illuminate\Support\Facades\Auth;

class DownloadAIValidationFile
{

    public function getAIValidationFileAttributes(object $file): array
    {
        return [
            'openai_id' => $file->id,
            'user_id'   => Auth::user()->id,
            'name'      => $file->filename,
            'byte_size' => $file->bytes,
            'file_purpose' => $file->purpose
        ];
    }

    public function updateAValidationFileInDB(object $file, AIValidationFile $aiFile): void
    {
        $aiFile::where('openai_id',$file->id)->update([ 
            'openai_id' => $file->id,
            'user_id'   => Auth::user()->id,
            'name'      => $file->filename,
            'byte_size' => $file->bytes,
            'file_purpose' => $file->purpose
        ]);
        
    }

}