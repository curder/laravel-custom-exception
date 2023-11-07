<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Services\CheckoutService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __invoke(Request $request)
    {
        /** @var Ticket $ticket */
        $ticket = Ticket::query()->findOrFail($request->ticket);
        $user = $request->user();

        // 1. 当用户的积分小于票价则不允许提交
        if ($user->credits < $ticket->price) {
            abort(401, 'Not enough credits');
        }

        // 2. 检查当前票数量是否满足所提交的需求
        if (!$ticket->isAvailable($request->amount)) {
            abort(404, 'Not enough tickets');
        }

        $purchase = app(CheckoutService::class)->purchaseTicket($user, $ticket);

        return response()->json([
            'message' => 'Ticket purchased successfully.',
        ]);
    }
}
