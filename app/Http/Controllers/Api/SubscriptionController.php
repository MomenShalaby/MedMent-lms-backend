<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    use HttpResponses;
    public function index()
    {
        $subscriptions = Subscription::all();
        return $this->success([
            'subscriptions' => $subscriptions,
        ]);
    }

    public function show(Subscription $subscription)
    {
        return $this->success(
            $subscription,
        );
    }

    public function update(Request $request, Subscription $subscription)
    {
        $request->validate([
            'price' => ['required', 'decimal:0,2'],
        ]);
        $subscription->update([
            'price' => $request->price
        ]);
        return $this->success(
            $subscription,
            'subscription price updated successfully',
        );
    }

}
