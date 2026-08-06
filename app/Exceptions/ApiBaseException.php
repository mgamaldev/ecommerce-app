<?php

namespace App\Exceptions;

use Exception;

abstract class ApiBaseException extends Exception
{
    abstract public function errorCode(): string;

    abstract public function status(): int;

    abstract public function logChannel(): string;

    public function context(): array
    {
        return [];
    }
}
