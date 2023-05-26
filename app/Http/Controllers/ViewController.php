<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

/**
* Renders the views
*/
class ViewController extends Controller
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

  
  public function uploadTraningData()
  {
    return Inertia::render('Models/UploadTraningData');
  }

  public function trainModels(string $id)
  {
    return Inertia::render('Models/TrainModels', ['id' =>$id]);
  }
  
  public function seeFineTuneJobs(string $id)
  {
    return Inertia::render('Models/SeeFineTuneJobs', ['id' => $id]);
  }

  public function seeModelResultFile(string $id)
  {
    return Inertia::render('Models/SeeModelResultFiles', ['id' => $id]);
  }
}