<?php
namespace App\Http\Controllers;

use App\Services\OpenAI\AIModel\AIModelService;
use App\Services\OpenAI\FineTuneJob\FineTuneJobDownloader;
use Illuminate\Support\Collection;
use stdClass;

class FineTuneJobController 
{
    /**
    * Gets all the jobs that matches a model in the database
    */
    public function getAllFineTuneJobs (AIModelService $aiModelService): Collection
    {
        $fineTuneJobDownloader = new FineTuneJobDownloader($aiModelService);

        return $fineTuneJobDownloader->getAllFineTuneJobs();
    }

    /**
    * Gets info about a single finetune job
    */
    public function getOneFineTuneJob(string $openaiModelId, AIModelService $aiModelService): stdClass
    {
        $fineTuneJobDownloader = new FineTuneJobDownloader($aiModelService);

        return $fineTuneJobDownloader->getAFineTuneJob($openaiModelId);
    }

    public function getAllFineTuneJobsForAModel(string $openai_id, AIModelService $aiModelService): Collection
    {
        $fineTuneJobDownloader = new FineTuneJobDownloader($aiModelService);

        return $fineTuneJobDownloader->getAllFineTuneJobsForAModel($openai_id);
    }
}