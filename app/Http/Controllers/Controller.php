<?php

namespace App\Http\Controllers;

use App\Models\AIFile;
use App\Services\OpenAI\AIFile\AIFilesDownloader;
use App\Services\OpenAI\AIFile\AIFileService;
use App\Services\OpenAI\AIFile\UploadAIFiles;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenAI;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    #Dette er bare til test af kode. skal ikke bruges i virkeligheden
    public function testGetAllFiles(AIFileService $aiFileService)
    {
        $aiFileDownloader = new AIFilesDownloader($aiFileService);

        return $aiFileDownloader->getAllFiles();
    }

    public function testUploadAFile(AIFileService $aiFileService)
    {
       $uploadAIFiles = new UploadAIFiles($aiFileService);

       return $uploadAIFiles->uploadAFile();
    }

    public function testDeleteAFile(AIFileService $aiFileService)
    {
        $yourApiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);

        $fileId = 'file-eBlYwUzXvF5dypkQk6FXmCRa';

        AIFile::where('openai_id', $fileId)->delete();

        return $aiFileService->deleteAFile($client, $fileId);
    }
}