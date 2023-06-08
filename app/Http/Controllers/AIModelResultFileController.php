<?php

namespace App\Http\Controllers;

use App\Services\OpenAI\AIModelResultFile\AIModelResultFileDownloader;
use App\Services\OpenAI\AIModelResultFile\AIModelResultFileService;
use Illuminate\Database\Eloquent\Collection;
use stdClass;

class AIModelResultFileController 
{
    function getAllModelResultFiles(AIModelResultFileService $aiModelResultFileService): Collection
    {
        $aiModelResultFileDownloader = new AIModelResultFileDownloader($aiModelResultFileService);

        return $aiModelResultFileDownloader->getAllModelResultFiles();
    }

    function downloadModelResultFile(string $resultFileId, AIModelResultFileService $aiModelResultFileService): array
    {
        $aiModelResultFileDownloader = new AIModelResultFileDownloader($aiModelResultFileService);

        return $aiModelResultFileDownloader->downloadModelResultFile($resultFileId);
    }

    function getModelResultFile(string $resultFileId, AIModelResultFileService $aiModelResultFileService): stdClass
    {
        $aiModelResultFileDownloader = new AIModelResultFileDownloader($aiModelResultFileService);

        return $aiModelResultFileDownloader->getModelResultFile($resultFileId);
    }
}