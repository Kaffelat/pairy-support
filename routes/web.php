<?php

use App\Http\Controllers\AIFileController;
use App\Http\Controllers\Controller;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
#<------This is test routes------->
#Shows all files on OpenAI
Route::get('/test/download', [AIFileController::class, 'testGetAllFiles']);

#Gets one file from OpenAI
Route::get('/test/get', [AIFileController::class, 'testGetAFile']);

#Uploads a file to OpenAI
Route::get('/test/upload', [AIFileController::class, 'testUploadAFile']);

#Deletes a file from OpenAI
Route::get('/test/delete', [AIFileController::class, 'testDeleteAFile']);

#Gets the information about a file from OpenAI
Route::get('/test/getone', [AIFileController::class, 'testGetInfoAboutAFile']);

#Gets all models a user has made at OpenAI
Route::get('/test/model/download', [Controller::class, 'getAllModels']);

Route::get('/test/model/get', [Controller::class, 'getInfoAboutModel']);

#Makes a new finetune model at OpenAI
Route::get('/test/model/upload', [Controller::class, 'makeModel']);

Route::get('/test/model/delete', [Controller::class, 'deleteModel']);


#<-------Test routes stops here-------->

Route::get('/models/seeModels', [OpenAIController::class, 'seeModels'])->name('models.seeModels');

Route::get('/models/makeModels', [OpenAIController::class, 'makeModels'])->name('models.makeModels');

Route::get('/models/seeTraningData', [OpenAIController::class, 'seeTraningData'])->name('models.seeTraningData');

Route::get('/models/trainModels', [OpenAIController::class, 'trainModels'])->name('models.trainModels');

Route::get('/models/uploadTraningData', [OpenAIController::class, 'uploadTraningData'])->name('models.uploadTraningData');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
