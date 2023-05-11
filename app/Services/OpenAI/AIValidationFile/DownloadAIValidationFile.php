<?php
namespace App\Services\OpenAI;

use App\Models\AIFile;
use App\Models\AIModelValidation;
use Illuminate\Support\Facades\Auth;

class DownloadAIModelValidation
{

    public function getAIModelValidationFileAttributes(object $file): array
    {
        return [
            'openai_id' => $file->id,
            'user_id'   => Auth::user()->id,
            'name'      => $file->filename,
            'byte_size' => $file->bytes,
            'file_purpose' => $file->purpose
        ];
    }

    public function updateAValidationFileInDB(object $file, AIModelValidation $aiFile): void
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