<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function updatePrice(Request $request, Subscription $subscription)
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

    public function selectSubscription(Request $request)
    {
        $request->validate([
            'subscription_id' => ['required', 'exists:subscriptions,id'],
        ]);

        $request->user()->update([$request->subscription_id]);
        return $this->success('', 'Subscriped successfully', 201);
    }
}
