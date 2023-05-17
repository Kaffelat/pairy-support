<?php

namespace App\Http\Controllers;

use App\Services\OpenAI\AIFile\AIFilesDownloader;
use App\Services\OpenAI\AIFile\AIFileService;
use App\Services\OpenAI\AIModelResultFile\AIModelResultFileDownloader;

class AIModelResultFileController 
{
    function getAllModelResultFiles(AIFileService $aiFileService)
    {
        $aiModelResultFileDownloader = new AIModelResultFileDownloader($aiFileService);

        return $aiModelResultFileDownloader->getAllModelResultFiles();
    }
}