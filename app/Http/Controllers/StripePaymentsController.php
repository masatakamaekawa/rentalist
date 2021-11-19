<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function charge(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));//シークレットキー

        $charge = Charge::create(array(
            'amount' => 100,
            'currency' => 'jpy',
            'source'=> request()->stripeToken,
        ));
    return back();
    }
}
