<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TransactionController;
use App\Models\User;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=> 'auth:sanctum'],function (){
    Route::apiResource('categories',CategoryController::class);
    Route::apiResource('transactions',TransactionController::class);
});
Route::post('/tokens/create', function (Request $request) {
    $user = User::find(1);
    $token = $user->createToken($user->email);
    return ['token' => $token->plainTextToken];
});

