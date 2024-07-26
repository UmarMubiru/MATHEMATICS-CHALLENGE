<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\ChallengeController;

// routes/web.php

use App\Http\Controllers\AnalyticsController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('customer/import', [App\Http\Controllers\CustomerController::class, 'index']);
Route::post('customer/import', [App\Http\Controllers\CustomerController::class, 'importExcelData']);
Route::get('/customer', 'CustomerController@index')->name('dashboard.customer.read');
Route::resource('customer', 'CustomerController');

Route::post('/import-questions', [QuestionsController::class, 'importExcelData'])->name('import.questions');

Route::get('/analytics', [AnalyticsController::class, 'allAnalytics']);



// Route for displaying the welcome page with challenge winners and top schools
Route::get('/', [ChallengeController::class, 'index']);



Route::get('answers/import', [App\Http\Controllers\AnswersController::class, 'index']);
Route::post('answers/import', [App\Http\Controllers\AnswersController::class, 'importExcelData']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';