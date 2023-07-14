<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Http\Request;
use App\Payment\PaypalService;

class CheckoutController extends Controller
{
    protected $payPal;

    public function __construct(PayPalController $payPal)
    {
        $this->payPal = $payPal;
    }

    public function getCheckout()
    {
        return view('site.pages.checkout');
    }

    public function placeOrder(Request $request)
    {
        // Before storing the order we should implement the
        // request validation which I leave it to you
        $order = Order::create([
            'order_number'      =>  'ORD-'.strtoupper(uniqid()),
            'user_id'           => auth()->user()->id,
            'status'            =>  'pending',
            'grand_total'       =>  CartFacade::getSubTotal(),
            'item_count'        =>  CartFacade::getTotalQuantity(),
            'payment_status'    =>  0,
            'payment_method'    =>  null,
            'first_name'        =>  $request->first_name,
            'last_name'         =>  $request->last_name,
            'address'           =>  $request->address,
            'city'              =>  $request->city,
            'country'           =>  $request->country,
            'post_code'         =>  $request->post_code,
            'phone_number'      =>  $request->phone_number,
            'notes'             =>  $request->notes
        ]);
    
        if ($order) {
    
            $items = CartFacade::getContent();
    
            foreach ($items as $item)
            {
                // A better way will be to bring the product id with the cart items
                // you can explore the package documentation to send product id with the cart
                $product = Product::where('name', $item->name)->first();
    
                $orderItem = new OrderItem([
                    'product_id'    =>  $product->id,
                    'quantity'      =>  $item->quantity,
                    'price'         =>  $item->getPriceSum()
                ]);
    
                $order->items()->save($orderItem);
            }
            $order->load('items');
            return $this->payPal->handlePayment($order);
        }
    
    }

    public function complete (Request $request)
    {

        $invoice = $this->payPal->paymentSuccess($request);
        $order = Order::where('order_number', $invoice)->first();
        $order->status = 'processing';
        $order->payment_status = 1;
        $order->payment_method = 'PayPal';
        $order->save();
    
        CartFacade::clear();
        return view('site.pages.success', compact('order'));
    
    }

}
