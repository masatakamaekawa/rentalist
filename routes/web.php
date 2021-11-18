<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use GuzzleHttp\Middleware;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\RentalController;

use function App\Http\Controllers\store;

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

Route::get('/', [PostController::class, 'index'])
    ->name('root');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('posts', PostController::class)
    ->middleware('auth')
    ->only(['create', 'store', 'edit', 'update', 'destroy']);

Route::resource('posts', PostController::class)
    ->only(['show', 'index']);

Route::resource('posts.comments', CommentController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth');

Route::get('/', [RentalController::class, 'index'])
    ->name('root');

Route::resource('rentals', RentalController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth');

Route::resource('rentals', RentalController::class)
    ->only(['show', 'index']);

Route::resource('rentals.comments', CommentController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth');

require __DIR__.'/auth.php';

// authから始まるルーティングに認証前にアクセスがあった場合
Route::prefix('auth')->middleware('guest')->group(function () {
    // auth/githubにアクセスがあった場合はOAuthControllerのredirectToProviderアクションへルーティング
    Route::get('/{provider}', [OAuthController::class, 'redirectToProvider'])
        ->where('provider', 'line|google')
        ->name('redirectToProvider');

    // auth/github/callbackにアクセスがあった場合はOAuthControllerのoauthCallbackアクションへルーティング
    Route::get('/{provider}/callback', [OAuthController::class, 'oauthCallback'])
        ->where('provider', 'line|google')
        ->name('oauthCallback');
});
