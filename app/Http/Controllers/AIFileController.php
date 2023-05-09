<?php

namespace App\Http\Controllers;

use App\Models\AIFile;
use App\Services\OpenAI\AIFile\AIFilesDownloader;
use App\Services\OpenAI\AIFile\AIFileService;
use App\Services\OpenAI\AIFile\UploadAIFiles;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use OpenAI;
use stdClass;

#Dette er bare til test af kode. skal ikke bruges i virkeligheden
class AIFileController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    #Henter alle filer på OpenAI
    public function testGetAllFiles(AIFileService $aiFileService): Collection
    {
        $aiFileDownloader = new AIFilesDownloader($aiFileService);

        return $aiFileDownloader->getAllFiles();
    }

    #Henter en specifik fil
    public function testGetAFile(AIFileService $aiFileService): stdClass
    {
        $aiFileDownloader = new AIFilesDownloader($aiFileService);
        return $aiFileDownloader->getAFile();
    }

    #Viser indeholdet i en bestemt fil
    public function testGetInfoAboutAFile(AIFileService $aiFileService): stdClass
    {
        $aiFileDownloader = new AIFilesDownloader($aiFileService);
        return $aiFileDownloader->getInfoAboutAFile();
    }

    #uploader en ny fil
    public function testUploadAFile(Request $request ,AIFileService $aiFileService): stdClass
    {
        $uploadAIFiles = new UploadAIFiles($aiFileService);

        return $uploadAIFiles->uploadAFile($request);
    }

    #sletter en fil
    public function testDeleteAFile(String $openaiFileId, AIFileService $aiFileService): stdClass
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        AIFile::where('openai_id', $openaiFileId)->delete();

        return $aiFileService->deleteAFile($client, $openaiFileId);
    }
}