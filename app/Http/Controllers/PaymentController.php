<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationPaidMail;

class PaymentController extends Controller
{
    public function pay(Request $request, Reservation $reservation)
    {
        $amount = $request->type === 'deposit'
            ? $reservation->restaurant->price * 0.3
            : $reservation->restaurant->price;

        $payment = Payment::create([
            'reservation_id' => $reservation->id,
            'amount' => $amount,
            'type' => $request->type,
            'status' => 'paid',
            'payment_method' => 'stripe',
        ]);

        Mail::to($reservation->user->email)
            ->send(new ReservationPaidMail($reservation));

        return redirect()->route('reservations.show', $reservation)
                         ->with('success', 'Paiement confirmé');
    }
}