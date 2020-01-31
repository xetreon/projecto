<?php

namespace App\Exceptions;

class UserNotFoundException extends BaseException
{
    public function __construct($message = 'Use Was Not Found') {
        parent::__construct($message, 404);
    }
}