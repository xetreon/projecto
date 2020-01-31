<?php

namespace App\Exceptions;

class DataNotFoundException extends BaseException
{
    public function __construct($message = 'Data Not Found') {
        parent::__construct($message, 404);
    }
}