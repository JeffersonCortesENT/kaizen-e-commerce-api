<?php

namespace App\Constants;

class AuthConstants
{
  public const LOGIN = 'login';
  public const LOGOUT ='logout';

  public const VALIDATION = 'validation';
  public const VALIDATION_MESSAGES = 'validation_messages';
  public const RESPONSE_MESSAGES = 'response_messages';

  public const SUCCESS = 'success';
  public const ERROR = 'error';

  public const INVALID_CREDENTIALS = 'The provided credentials are incorrect.';
  public const LOGGED_OUT_SUCCESSFULLY = 'Logged out successfully';
  
  public const BLANK_TOKEN = 'Token not provided';
  public const INVALID_TOKEN = 'Invalid token';
  public const EXPIRED_TOKEN = 'Unauthorized access. Token may be expired.';

  public const LOGIN_ACTION = [
    self::VALIDATION => [
      'email' => 'required|email',
      'password' => 'required|min:8',
    ],
    self::VALIDATION_MESSAGES => [
      'email.required' => 'Email is required.',
      'email.email' => 'Enter a valid email address.',
      'password.required' => 'Password is required.',
      'password.min' => 'Password must be at least 8 characters.',
    ],
  ];
}
