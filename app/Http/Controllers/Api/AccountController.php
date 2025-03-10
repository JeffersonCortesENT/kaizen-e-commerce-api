<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    // protected $authService;

    // public function __construct(AuthService $authService)
    // {
    //     $this->authService = $authService;
    // }

    public function createAction(Request $request)
    {
        return response()->json(['message' => 'hello']);
    }
}
