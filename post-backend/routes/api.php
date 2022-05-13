<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login',[AuthController::class, 'login']);
Route::post('/register',[AuthController::class, 'register']);
Route::get('/login',function(){
return response()->json(['message'=>'Unauthorised'],401);
})->name('login');
Route::middleware('auth:api')->group(function(){
    Route::post('/logout',[AuthController::class,'logout']);
    Route::get('/users',[AuthController::class,'index']);
    Route::get('/users/{id}',[AuthController::class,'show']);
    Route::get('get-search',[PostController::class,'search']);
    Route::apiResource('posts',PostController::class);
});