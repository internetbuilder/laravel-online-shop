<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal;

class PayPalController extends Controller
{
    
    public function handlePayment($order)
    {
        $data = [];

        $provider = new PayPal();
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        
        
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('checkout.payment.complete'),
                "cancel_url" => route('checkout.index'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $order->grand_total,
                    ],
                    "invoice_id" => $order->order_number,
                ]
            ]

        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
                ->route('checkout.index')
                ->with('error', 'Something went wrong.');
        } else {
            return redirect()
                ->route('checkout.index')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function paymentCancel()
    {
        return redirect()
            ->route('checkout.index')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }

    public function paymentSuccess(Request $request)
    {
        $provider = new PayPal();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);



        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $invoiceId = $response['purchase_units'][0]['payments']['captures'][0]['invoice_id'];

            return $invoiceId;
        } else {
            return redirect()
                ->route('checkout.index')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }
}
