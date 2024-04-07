<?php

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\ReadingInterval;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login', 'AuthController@login')->name('login');
Route::group(['prefix' => 'v1'],function(){
        Route::post('reading-interval',[App\Http\Controllers\ReadingIntervalController::class, 'store']);
        Route::get('recommended-books',[App\Http\Controllers\ReadingIntervalController::class, 'mostRecommended']);
    });
