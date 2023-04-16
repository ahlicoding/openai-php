<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use App\Http\Controllers\OpenAIController;

Route::post('/openai/generate-completion', [OpenAIController::class, 'generateCompletion']);
Route::get('/', [OpenAIController::class, 'index']);
Route::post('/chat', [OpenAIController::class, 'chat']);



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
