<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function()
{
    Route::get('/posts', [PostController::class, 'index'] );
    Route::post('/posts', [PostController::class, 'store'] );
    Route::get('/posts/{id}', [PostController::class, 'show'] );
    Route::put('/posts/{id}', [PostController::class, 'update'] );
    Route::delete('/posts/{id}', [PostController::class, 'destroy'] );
    Route::post('/gambar', [FileController::class, 'create'] );
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/ps', [PController::class, 'posts']);
Route::get('/p/{p_id}', [PController::class, 'getPostsById']);
Route::post('/p', [PController::class, 'store']);
Route::put('/p/{p_id}', [PController::class, 'update']);
Route::delete('/p/{p_id}', [PController::class, 'delete']);

















//Route::get('/p/{p_id}/comments', [PController::class, 'getPostWithComments']);


