<?php
namespace App\Http\Controllers;

use App\Services\OpenAI\AIModel\AIModelService;
use App\Services\OpenAI\FineTuneJob\FineTuneJobDownloader;
use stdClass;

class FineTuneJobController 
{
    /**
    * Gets all the jobs that matches a model in the database
    */
    public function getAllFineTuneJobs (AIModelService $aiModelService): stdClass
    {
        $fineTuneJobDownloader = new FineTuneJobDownloader($aiModelService);

        return dd($fineTuneJobDownloader->getAllFineTuneJobs());
    }

    /**
    * Gets info about a single finetune job
    */
    public function getAModelsFineTuneJobs(AIModelService $aiModelService): stdClass
    {
        $fineTuneJobDownloader = new FineTuneJobDownloader($aiModelService);

        return dd($fineTuneJobDownloader->getAFineTuneJob());
    }
}