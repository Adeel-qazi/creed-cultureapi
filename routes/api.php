<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);



Route::group(['middleware'=> 'auth:api'],function(){
    
    Route::group(['middleware'=>'admin'],function(){

        Route::get('profile/{userId}', [UserController::class, 'show']);
        Route::put('profile/{userId}', [UserController::class, 'update']);

        //users management
        Route::get('status-update/{userId}',[UserController::class, 'statusUpdated']);
        Route::get('users',[UserController::class, 'fetchUser']);
        Route::post('add-user',[UserController::class, 'addUser']);
        Route::get('edit-user/{userId}',[UserController::class, 'editUser']);
        Route::put('update-user/{userId}',[UserController::class, 'updateUser']);
        Route::delete('delete-user/{userId}',[UserController::class, 'destroyUser']);

        Route::resource('blogs',BlogController::class);
        Route::resource('articles',ArticleController::class);

        Route::resource('comments',CommentController::class);
        Route::apiResource('likes',LikeController::class);



    });

    Route::group(['middleware'=>'user'],function(){

        Route::get('profile/{userId}',[UserController::class,'show']);
        Route::put('profile/{userId}',[UserController::class,'update']);

    });
});