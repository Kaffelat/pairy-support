<?php

use App\Http\Controllers\AIFileController;
use App\Http\Controllers\AIModelController;
use App\Http\Controllers\AIModelResultFileController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FineTuneJobController;
use App\Http\Controllers\OpenAIController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/test', [Controller::class,'test']);
Route::get('/test/validation', [Controller::class,'testGetAIValidationFiles']);

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
#<------This is file routes------->

#Shows all files on OpenAI
Route::get('/file/download', [AIFileController::class, 'GetAllFiles']);

#Gets one file from OpenAI
Route::get('/file/get', [AIFileController::class, 'GetFile']);

#Uploads a file to OpenAI
Route::post('/file/upload', [AIFileController::class, 'UploadAFile']);

#Deletes a file from OpenAI
Route::delete('/file/delete/{id}', [AIFileController::class, 'DeleteAFile']);

#<-----This is modelReusltFile routes ------>

Route::get('/resultFile/download', [AIModelResultFileController::class, 'getAllModelResultFiles']);

Route::get('/resultFile/get/{id}', [AIModelResultFileController::class, 'getModelResultFile'])->name('modelResultFile.get');
#<-----This is model routes------->

#Gets all models a user has made at OpenAI
Route::get('/model/download', [AIModelController::class, 'getAllModels']);

#Gets a single ai model
Route::get('/model/get', [AIModelController::class, 'getInfoAboutModel']);

#Makes a new finetune model at OpenAI
Route::post('/model/upload', [AIModelController::class, 'makeAIModel']);

#Deletes a finetune model
Route::delete('/model/delete/{id}', [AIModelController::class, 'deleteModel']);

#<------- This is FineTuneJob routes ------->

#Gets a single FineTuneJob
Route::get('/fineTuneJob/getone', [FineTuneJobController::class, 'getFineTuneJob']);

#Gets all FineTuneJob that matches a model in the database
Route::get('/fineTuneJob/download', [FineTuneJobController::class, 'getAllFineTuneJobs']);

Route::get('/fineTuneJob/get/{id}', [FineTuneJobController::class, 'getAllFineTuneJobsForAModel'])->name('fineTuneJob.get');

#<------- This is the view routes ------->

Route::get('/models/seeModels', [OpenAIController::class, 'seeModels'])->name('models.seeModels');

Route::get('/models/makeModels', [OpenAIController::class, 'makeModels'])->name('models.makeModels');

Route::get('/models/seeTraningFiles', [OpenAIController::class, 'seeTraningFiles'])->name('models.seeTraningFiles');

Route::get('/models/trainModels', [OpenAIController::class, 'trainModels'])->name('models.trainModels');

Route::get('/models/uploadTraningData', [OpenAIController::class, 'uploadTraningData'])->name('models.uploadTraningData');

Route::get('models/seeFineTuneJobs/{id}', [OpenAIController::class, 'seeFineTuneJobs'])->name('models.seeFineTuneJobs');

Route::get('models/seeModelResultFiles/{id}', [OpenAIController::class, 'seeModelResultFile'])->name('models.seeModelResultFiles');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
