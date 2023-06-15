<?php
namespace App\Http\Controllers;

use App\Services\OpenAI\FineTuneJob\FineTuneJobDownloader;
use App\Services\OpenAI\FineTuneJob\FineTuneJobService;
use Illuminate\Support\Collection;
use stdClass;

class FineTuneJobController 
{
    /**
    * Gets all the jobs that matches a model in the database
    */
    public function getAllFineTuneJobs(FineTuneJobService $fineTuneJobService): Collection
    {
        $fineTuneJobDownloader = new FineTuneJobDownloader($fineTuneJobService);

        return $fineTuneJobDownloader->getAllFineTuneJobs();
    }

    /**
    * Gets info about a single finetune job
    */
    public function getFineTuneJob(string $openaiModelId, FineTuneJobService $fineTuneJobService): stdClass
    {
        $fineTuneJobDownloader = new FineTuneJobDownloader($fineTuneJobService);
        
        return $fineTuneJobDownloader->getAFineTuneJob($openaiModelId);
    }
    /**
    * Gets all FineTuneJobs for a specific model
    */
    public function getAllFineTuneJobsForAModel(string $openaiModelId, FineTuneJobService $fineTuneJobService): Collection
    {
        $fineTuneJobDownloader = new FineTuneJobDownloader($fineTuneJobService);

        return $fineTuneJobDownloader->getAllFineTuneJobsForAModel($openaiModelId);
    }
}