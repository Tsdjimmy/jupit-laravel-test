<?php

namespace App\Constants;

class AppMessages
{
    // General
    public const REQUEST_SUCCESSFUL = 'Request successful.';
    public const INTERNAL_SERVER_ERROR = 'Internal server error.';
    public const RESOURCE_NOT_FOUND = 'Resource not found.';

    // Auth-specific
    public const REGISTRATION_SUCCESSFUL = 'Registration successful.';
    public const REGISTRATION_FAILED = 'Registration failed.';
    public const LOGIN_SUCCESSFUL = 'Login successful.';
    public const LOGIN_FAILED = 'Login failed. Unauthorized.';
    public const WELCOME_MESSAGE = 'Welcome to our application! This is from Laravel';
    public const UNAUTHORIZED = 'Unauthorized';
}
