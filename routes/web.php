<?php

use App\Http\Controllers\AchievementsController;
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

Route::get('/watched',[AchievementsController::class,'watched']);
Route::get('/{id}', [AchievementsController::class, 'watchedLesson']);

Route::get('/users/{user}/achievements', [AchievementsController::class, 'index']);

Route::get('/',function(){
    return csrf_token();
});
Route::post('/comment',[AchievementsController::class,'comment']);
