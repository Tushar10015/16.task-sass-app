<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Checkout;
use App\Models\Team;
use Illuminate\Support\Facades\Log;

class BillingController extends Controller
{
    public function redirectToCheckout(Request $request)
    {
        $team = auth()->user()->currentTeam;

        $checkout = $team->newSubscription('default', 'price_1RjHs3PqRcKc5tWrkjdYEimv')
            ->checkout([
                'success_url' => route('billing.success'),
                'cancel_url' => route('billing.cancel'),
            ]);

        // Log::info('Checkout URL', ['url' => $checkout]);

        // 👇 Return the checkout URL instead of redirect
        return response()->json([
            'checkout_url' => $checkout->url
        ]);
    }

    public function success()
    {
        return redirect()->route('dashboard')->with('success', 'Subscribed!');
    }

    public function cancel()
    {
        return redirect()->route('dashboard')->with('error', 'Subscription canceled.');
    }
}
