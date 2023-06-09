<?php

namespace App\Http\Controllers;

use App\Services\OpenAI\AIFile\AIFilesDownloader;
use App\Services\OpenAI\AIFile\AIFileService;
use App\Services\OpenAI\AIFile\UploadAIFiles;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use stdClass;

class AIFileController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
    * Gets all files
    */
    public function GetAllFiles(AIFileService $aiFileService): Collection
    {
        $aiFileDownloader = new AIFilesDownloader($aiFileService);

        return $aiFileDownloader->getAllFiles();
    }

    /**
    * Uploads a new file to OpenAI
    */
    public function UploadAFile(Request $request ,AIFileService $aiFileService): stdClass
    {
        $uploadAIFiles = new UploadAIFiles($aiFileService);

        return $uploadAIFiles->uploadAFile($request);
    }

    /**
    * Deletes a file 
    */
    public function DeleteAFile(String $openaiFileId, AIFileService $aiFileService): stdClass
    {
        return $aiFileService->deleteAFile($openaiFileId);
    }
}