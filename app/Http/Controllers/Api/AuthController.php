<?php

namespace App\Http\Controllers\Api;

use App\Constants\ApiConstants;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function loginAction(LoginRequest $request)
    {
      $account = $this->authService->authenticate($request);

      if ($account[ApiConstants::MESSAGE] instanceof Account) {
        Gate::authorize('canLogin', $account[ApiConstants::MESSAGE]);
      }

      return response()->json($account);
    }

    public function logoutAction(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function returnUnauthorized(Request $request) {
      return response()->json([
        ApiConstants::SUCCESS => false,
        ApiConstants::CODE => 403,
        ApiConstants::MESSAGE => 'Unauthorized',
      ]);
    }
}
