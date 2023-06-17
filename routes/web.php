<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

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

Route::get('/', Controllers\HomeController::class)->name('home.index');
Route::get('/developers', Controllers\Developers\IndexController::class)->name('developers.index');
Route::get('/developers/{developer}', Controllers\Developers\DetailController::class)->name('developers.detail');

Route::get('/user/developers', function () {
    return view('pages.developers');
})->name('developers.create');

Route::get('/jobs', Controllers\Jobs\IndexController::class)->name('jobs.index');
Route::get('/jobs/{job}', fn () => 'Hello world')->name('jobs.detail');

Route::get('/about', function () {
    return view('pages.about');
})->name('about.index');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/developers/hire/{developer}', Controllers\Developers\HireController::class)->name('developers.hire');
    Route::get('/user/jobs/create', Controllers\Jobs\CreateController::class)->name('jobs.create');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'role:admin'
])->group(function () {
    Route::get('admin/dashboard', function () {
        return view('pages.developers');
    });
});

Route::get('auth/google', [Controllers\GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [Controllers\GoogleController::class, 'handleGoogleCallback']);

Route::get('auth/github', [Controllers\GithubController::class, 'redirectToGithub']);
Route::get('auth/github/callback', [Controllers\GithubController::class, 'handleGithubCallback']);
