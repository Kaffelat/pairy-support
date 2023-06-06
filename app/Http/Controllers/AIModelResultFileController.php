<?php

namespace App\Http\Controllers;

use App\Services\OpenAI\AIFile\AIFileService;
use App\Services\OpenAI\AIModelResultFile\AIModelResultFileDownloader;
use App\Services\OpenAI\AIModelResultFile\AIModelResultFileService;

class AIModelResultFileController 
{
    function getAllModelResultFiles(AIFileService $aiFileService, AIModelResultFileService $aiModelResultFileService)
    {
        $aiModelResultFileDownloader = new AIModelResultFileDownloader($aiFileService, $aiModelResultFileService);

        return $aiModelResultFileDownloader->getAllModelResultFiles();
    }

    function downloadModelResultFile(string $resultFileId, AIFileService $aiFileService, AIModelResultFileService $aiModelResultFileService)
    {
        $aiModelResultFileDownloader = new AIModelResultFileDownloader($aiFileService, $aiModelResultFileService);

        return $aiModelResultFileDownloader->downloadModelResultFile($resultFileId);
    }

    function getModelResultFile(string $resultFileId, AIFileService $aiFileService, AIModelResultFileService $aiModelResultFileService)
    {
        $aiModelResultFileDownloader = new AIModelResultFileDownloader($aiFileService, $aiModelResultFileService);

        return $aiModelResultFileDownloader->getModelResultFile($resultFileId);
    }
}