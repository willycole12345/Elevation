<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;


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

Route::post('/CreateAccount', [AccountController::class, 'CreateAccount']);
Route::patch('/UpdateAccount/{UpdateAccount}', [AccountController::class, 'UpdateAccount']);
//Route::get('send-mail', [AccountController::class, 'sendVerificationmail']);
Route::post('verify_users', [AccountController::class, 'verify_users']);

Route::post('image_upload/{UpdateImage}', [AccountController::class, 'image_upload']);