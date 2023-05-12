<?php
namespace App\Services\OpenAI\AIValidationFile;

use App\Models\AIValidationFile;
use Illuminate\Support\Facades\Auth;

class DownloadAIValidationFile
{

    public function getAIValidationFileAttributes(object $file): array
    {
        return [
            'openai_id' => $file->id,
            'ai_model_id' => $this->getAIModelID($file),
            'ai_file_id' => $this->getAIFileID($file),
            'name'      => $file->filename,
            'byte_size' => $file->bytes,
            'file_purpose' => $file->purpose
        ];
    }

    public function updateAValidationFileInDB(object $file): void
    {
        AIValidationFile::where('openai_id',$file->id)->update([ 
            'openai_id' => $file->id,
            'ai_model_id' => $this->getAIModelID($file),
            'ai_file_id' => $this->getAIFileID($file),
            'name'      => $file->filename,
            'byte_size' => $file->bytes,
            'file_purpose' => $file->purpose
        ]);
        
    }

    public function getAIModelID(object $file): string
    {
        $aiValidationFileService = new AIValidationFileService;

        
        return '';
    }

    public function getAIFileID(object $file): string
    {
        return '';
    }
}