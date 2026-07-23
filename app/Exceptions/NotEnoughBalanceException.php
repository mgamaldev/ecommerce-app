<?php

namespace App\Exceptions;

class NotEnoughBalanceException extends ApiBaseException
{
    protected $message = 'Insufficient balance';

    public function errorCode(): string
    {
        return 'INSUFFICIENT_BALANCE';
    }

    public function status(): int
    {
        return 409;
    }

    public function logChannel(): string
    {
        return 'payment';
    }
}
