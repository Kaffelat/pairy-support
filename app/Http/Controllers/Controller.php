<?php

namespace App\Http\Controllers;

use App\Models\AIModel;
use App\Services\OpenAI\AIFile\UploadAIFiles;
use App\Services\OpenAI\AIModel\AIModelDownloader;
use App\Services\OpenAI\AIModel\AIModelService;
use App\Services\OpenAI\AIModel\UploadAIModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenAI;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

}