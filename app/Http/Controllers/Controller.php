<?php

namespace App\Http\Controllers;

use App\Services\OpenAI\AIFile\AIFilesDownloader;
use App\Services\OpenAI\AIFile\AIFileService;
use App\Services\OpenAI\AIValidationFile\AIValidationFileDownloader;
use App\Services\OpenAI\AIValidationFile\AIValidationFileService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

use OpenAI;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function test(AIFileService $aiFileService): Collection {
        
        $aiFileDownloader = new AIFilesDownloader($aiFileService);

        return dd($aiFileDownloader->test());
        
    }

    function testGetAIValidationFiles(AIValidationFileService $aIValidationFileService): Collection {

        $aiValidationDownloader = new AIValidationFileDownloader($aIValidationFileService);
        
        return dd($aiValidationDownloader->getAllValidationFiles());
    }
}