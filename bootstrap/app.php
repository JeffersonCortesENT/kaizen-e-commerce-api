<?php

use App\Constants\ApiConstants;
use App\Constants\AuthConstants;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException as LaravelAuthException;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->redirectGuestsTo(fn (Request $request) => route('redirect.403'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
      $exceptions->render(function (Throwable $exception, Request $request) {
        if ($request->is('api/*')) {
          dd($exception);
          if ($exception instanceof LaravelAuthException) {
              $message = $exception->getMessage();
              $token = $request->bearerToken();
              if ($token) {
                if (!$token) {
                    $message = AuthConstants::BLANK_TOKEN;
                }
                // Extract token ID and raw token
                $parts = explode('|', $token);
                $rawToken = isset($parts[1]) ? $parts[1] : $token; // If token has an ID, use only the actual token

                // Hash token for lookup
                $hashedToken = hash('sha256', $rawToken);
                $accessToken = PersonalAccessToken::where('token', $hashedToken)->first();

                if (!$accessToken) {
                    return $message = AuthConstants::INVALID_TOKEN;
                }

                // Delete the token if it's expired
                if ($accessToken && $accessToken->expires_at && $accessToken->expires_at->isPast()) {
                    $accessToken->delete();
                    $message = AuthConstants::EXPIRED_TOKEN;
                }
              }

              return response()->json([
                  ApiConstants::SUCCESS => false,
                  ApiConstants::MESSAGE => $message,
              ], 401);
          }

          if ($exception instanceof ValidationException) {
              return response()->json([
                ApiConstants::SUCCESS => false,
                ApiConstants::MESSAGE => 'Validation failed.',
                ApiConstants::ERRORS => $exception->errors(),
              ], 422);
          }

          if ($exception instanceof AccessDeniedHttpException) {
              return response()->json([
                  ApiConstants::SUCCESS => false,
                  ApiConstants::MESSAGE => $exception->getMessage(),
              ], 403);
          }

          return response()->json([
            ApiConstants::SUCCESS => false,
            ApiConstants::MESSAGE => $exception->getMessage(),
          ], 500);
        }
    });
    })->create();
