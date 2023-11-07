<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;

class NotEnoughTicketsException extends Exception
{
    public function validationMessage(): ValidationException
    {
        return ValidationException::withMessages([
            'ticket' => 'Not enough tickets',
        ]);
    }
}
