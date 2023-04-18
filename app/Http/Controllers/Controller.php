<?php

namespace App\Http\Controllers;

use App\Models\AIFile;
use App\Services\OpenAI\AIFile\AIFilesDownloader;
use App\Services\OpenAI\AIFile\AIFileService;
use App\Services\OpenAI\AIFile\DownloadAIFIles;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;
use OpenAI;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    #Dette er bare til test af kode. skal ikke bruges i virkeligheden
    public function testGetAllFiles(AIFileService $aiFile)
    {
        $aiFileDownloader = new AIFilesDownloader;

        return $aiFileDownloader->getAllFiles($aiFile);
    }

}