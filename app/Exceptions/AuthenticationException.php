<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class AuthenticationException extends Exception
{
    public function __construct(string $message = "Authentication failed.", int $code = 401)
    {
        parent::__construct($message, $code);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
        ], $this->getCode());
    }
}
