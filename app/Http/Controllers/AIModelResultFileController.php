<?php

namespace App\Http\Controllers;

use App\Services\OpenAI\AIModelResultFile\AIModelResultFileDownloader;
use App\Services\OpenAI\AIModelResultFile\AIModelResultFileService;

class AIModelResultFileController 
{
    function getAllModelResultFiles(AIModelResultFileService $aiModelResultFileService)
    {
        $aiModelResultFileDownloader = new AIModelResultFileDownloader($aiModelResultFileService);

        return $aiModelResultFileDownloader->getAllModelResultFiles();
    }

    function downloadModelResultFile(string $resultFileId, AIModelResultFileService $aiModelResultFileService)
    {
        $aiModelResultFileDownloader = new AIModelResultFileDownloader($aiModelResultFileService);

        return $aiModelResultFileDownloader->downloadModelResultFile($resultFileId);
    }

    function getModelResultFile(string $resultFileId, AIModelResultFileService $aiModelResultFileService)
    {
        $aiModelResultFileDownloader = new AIModelResultFileDownloader($aiModelResultFileService);

        return $aiModelResultFileDownloader->getModelResultFile($resultFileId);
    }
}