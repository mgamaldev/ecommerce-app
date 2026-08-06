<?php

namespace App\Exceptions;

class ValidationException extends ApiBaseException
{
    protected $message = 'Validation Failed';

    public function errorCode(): string
    {
        return 'VALIDATION_ERROR';
    }

    public function status(): int
    {
        return 422;
    }

    public function logChannel(): string
    {
        return 'api';
    }
}
