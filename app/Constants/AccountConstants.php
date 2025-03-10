<?php

namespace App\Constants;

class Account
{
    public const USER_ROLE_ADMIN = 'admin';
    public const USER_ROLE_CUSTOMER = 'customer';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';

    public const LOGIN_MESSAGES = [
      200 => 'Login successfully',
      400 => 'The provided credentials are incorrect.',
      500 => 'An error has occured!',
    ];
}
