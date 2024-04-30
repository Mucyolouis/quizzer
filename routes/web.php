<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Questions\QuestionForm;
use App\Livewire\Questions\QuestionList;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SocialiteController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::middleware('isAdmin')->group(function () { 
        Route::get('questions', QuestionList::class)->name('questions'); 
        Route::get('questions/create', QuestionForm::class)->name('questions.create'); 
        Route::get('questions/{question}', QuestionForm::class)->name('questions.edit'); 
    }); 
});


Route::middleware('guest')->group(function () {
    // ...
    Route::get('auth/{provider}/redirect', [SocialiteController::class, 'loginSocial'])
        ->name('socialite.auth');
 
    Route::get('auth/{provider}/callback', [SocialiteController::class, 'callbackSocial'])
        ->name('socialite.callback');
});

require __DIR__.'/auth.php';
