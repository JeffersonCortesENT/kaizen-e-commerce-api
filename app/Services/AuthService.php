<?php

namespace App\Services;

use App\Constants\ApiConstants;
use App\Constants\AuthConstants;
use App\Exceptions\AuthenticationException;
use App\Repositories\AccountRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthService
{
    protected $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function authenticate(Request $request)
    {
        if (!(Auth::attempt(['email' => $request->email, 'password' => $request->password]))) {
            throw new AuthenticationException(AuthConstants::INVALID_CREDENTIALS);
        }

        $account = Auth::user();
        $token = $account->createToken('auth_token', ['*'], Carbon::now()->addHour())->plainTextToken;

         return [
          ApiConstants::SUCCESS => true,
          ApiConstants::CODE => 200,
          ApiConstants::DATA => $token,
          ApiConstants::MESSAGE => $account,
        ];
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        return [
          ApiConstants::SUCCESS => true,
          ApiConstants::CODE => 200,
          ApiConstants::MESSAGE => AuthConstants::LOGGED_OUT_SUCCESSFULLY,
        ];
    }
}
