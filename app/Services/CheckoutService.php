<?php

namespace App\Services;

use App\Exceptions\NotEnoughCreditsException;
use App\Exceptions\NotEnoughTicketsException;
use App\Models\Purchse;
use App\Models\Ticket;
use App\Models\User;
use Throwable;

class CheckoutService
{
    /**
     * @throws NotEnoughCreditsException|NotEnoughTicketsException
     * @throws Throwable
     */
    public function purchaseTicket(User $user, Ticket $ticket, int $amount): Purchse
    {
        // 1. 当用户的积分小于票价则不允许提交
        throw_if($user->credits < $ticket->price, new NotEnoughCreditsException);

        // 2. 检查当前票数量是否满足所提交的需求
        throw_if(!$ticket->isAvailable($amount), new NotEnoughTicketsException);

        $user->credits -= $ticket->price;

        return new Purchse;
    }
}
