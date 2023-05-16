<?php

namespace App\Http\Controllers;

use App\Models\AIModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use OpenAI;

/**
* Renders the views
*/
class OpenAIController extends Controller
{   
  public function seeModels()
  {
    return Inertia::render('Models/SeeModels');
  }
  
  public function makeModels()
  {
    return Inertia::render('Models/MakeModels');
  }
   
  public function seeTraningFiles()
  {
    return Inertia::render('Models/SeeTraningFiles');
  }

  public function trainModels()
  {
    return Inertia::render('Models/TrainModels');
  }

  public function uploadTraningData()
  {
    return Inertia::render('Models/UploadTraningData');
  }

  public function seeFineTuneJobs(string $id)
  {
    return Inertia::render('Models/SeeFineTuneJobs');
  }
}