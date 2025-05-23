<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('users', UserController::class);
    Route::apiResource('roles', RoleController::class);
    
    Route::post('/logout', [AuthController::class, 'logout']);
});




// Route::get('/', function(){
//     return 'API';
// });

