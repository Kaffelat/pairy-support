<?php

namespace App\Http\Controllers;

use App\Models\AIModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use OpenAI;

class OpenAIController extends Controller
{   
  public function index()
  {
    return Inertia::render('Models/Index', [
      'ai_models' => AIModel::All()
    ]);
  }
 
  public function seeModels()
  {
    return Inertia::render('Models/SeeModels');
  }
  
  public function makeModels()
  {
    return Inertia::render('Models/MakeModels');
  }
   
  public function seeTraningData()
  {
    return Inertia::render('Models/SeeTraningData');
  }

  public function trainModels()
  {
    return Inertia::render('Models/TrainModels');
  }

  public function uploadTraningData()
  {
    return Inertia::render('Models/UploadTraningData');
  }

}