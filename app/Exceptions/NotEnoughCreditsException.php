<?php

namespace App\Exceptions;

use Exception;

class NotEnoughCreditsException extends Exception
{
    public function message(): string
    {
        return 'Not enough credits';
    }
}
