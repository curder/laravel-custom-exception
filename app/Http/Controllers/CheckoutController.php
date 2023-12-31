<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Ticket;
use App\Services\CheckoutService;
use App\Http\Requests\CheckoutRequest;
use App\Exceptions\NotEnoughCreditsException;
use App\Exceptions\NotEnoughTicketsException;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    /**
     * @throws Throwable
     */
    public function __invoke(CheckoutRequest $request)
    {
        /** @var Ticket $ticket */
        $ticket = Ticket::query()->findOrFail($request->ticket);
        $user = $request->user();

        try {
            $purchase = app(CheckoutService::class)->purchaseTicket($user, $ticket, $request->amount);

            return response()->json([
                'message' => 'Ticket purchased successfully.',
            ]);
        } catch (NotEnoughCreditsException $exception) {
            // abort(401, $exception->message());
            throw ValidationException::withMessages(['credits' => 'Not enough credits'])->status(401);
        } catch (NotEnoughTicketsException $exception) {
            throw $exception->validationMessage();
        }
    }
}
