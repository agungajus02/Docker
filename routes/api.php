<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware'=>
['authsanctum'],'prefix'=> 'job'], function(){
    Route::post('/getJob',
    [JobController::class, 'getJob'])->name
    ('getJob');
});
