<?php

namespace App\Services;

use App\Models\Purchse;
use App\Models\Ticket;
use App\Models\User;

class CheckoutService
{
    public function purchaseTicket(User $user, Ticket $ticket): Purchse
    {
        $user->credits -= $ticket->price;

        return new Purchse;
    }
}
