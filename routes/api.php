<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Middleware\TokenExpirationMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// Public Authentication Routes
Route::prefix('auth')
  ->controller(AuthController::class)
  ->group(function () {
      Route::post('/login', 'loginAction');
      Route::post('/register', 'createAccount');
      Route::post('/logout', 'logoutAction')->middleware('auth:sanctum');
});


Route::prefix('account')
  ->middleware(['auth:sanctum'])
  ->controller(AccountController::class)
  ->group(function () {
    Route::get('/', 'createAction');
});

Route::prefix('redirect')->controller(AuthController::class)->group(function () {
  Route::get('/403', 'returnUnauthorized')->name('redirect.403');
});

Route::middleware('auth:sanctum')->get('/debug-auth', function (Request $request) {
  return response()->json([
      'auth_user' => Auth::user(),
      'request_user' => $request->user(),
      'headers' => $request->headers->all()
  ]);
});
