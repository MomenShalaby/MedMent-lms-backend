<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Srmklive\PayPal\Services\PayPal as PayPalClient;


class PaypalController extends Controller
{
    use HttpResponses;
    private $provider;
    public function __construct()
    {
        $this->provider = $this->initializePayPalClient();

    }
    public function processTransaction(PaymentRequest $request)
    {

        $order = $this->createPaypalOrder($request);
        return $this->success($order, "data is here", 200);

    }

    public function successTransaction(Request $request)
    {
        // $data = json_decode($request->getContent());
        $orderId = $request->orderId;
        // $data = json_decode($request->getContent(), true);
        // $orderId = $data['orderId'];

        $result = $this->capturePaypalPayment($orderId);

        return $this->success($result, "data is here", 200);

    }


    private function initializePayPalClient()
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        return $provider;
    }
    private function createPaypalOrder($request)
    {
        $price = $request->value;
        $data = [
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $price
                    ]
                ]
            ]
        ];
        $order = $this->provider->createOrder($data);
        return $order;
    }

    private function capturePaypalPayment($token)
    {
        $response = $this->provider->capturePaymentOrder($token);
        try {
            DB::beginTransaction();

            if ($response['status'] == 'COMPLETED') {
                $payment = new Payment;
                $payment->payment_id = $response['id'];
                $payment->user_id = Auth::id();
                $payment->amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
                $payment->currency = $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'];
                $payment->payment_status = $response['status'];
                $payment->payment_method = "PayPal";
                $payment->save();
                DB::commit();

                return $response;
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error("Transaction Error: " . $e->getMessage());
        }


    }

}
