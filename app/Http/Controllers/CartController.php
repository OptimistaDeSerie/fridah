<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Address;
use App\Models\State;
use App\Models\DeliveryFee;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Http\Client\HttpClientException;
use App\Mail\OrderPlacedMail;
use Illuminate\Support\Facades\Mail;


class CartController extends Controller

{
    public function index(){
        $currency = "₦";
        $cartItems = Cart::instance('cart')->content();
        return view('cart',compact('cartItems','currency'));
    }

    public function add_to_cart(Request $request){
        $request->validate([
            'id'       => 'required|exists:products,id',
            'size_id'  => 'required|exists:product_sizes,id',
            'quantity' => 'required|integer|min:1',
            'price'    => 'required|numeric',
        ]);

        $size = ProductSize::findOrFail($request->size_id);

        Cart::instance('cart')->add([
            'id'      => $request->id . '-' . $size->id, //  unique per size
            'name'    => $request->name,                 //  clean name
            'qty'     => $request->quantity,
            'price'   => $request->price,
            'options' => [
                'product_id' => $request->id,
                'size_id'   => $size->id,
                'size_name' => $size->size,              //  readable
            ],
        ])->associate('App\Models\Product');

        return response()->json([
            'status'   => 'success',
            'message'  => 'Product added to cart successfully!',
            'count'    => Cart::instance('cart')->count(),
            'subtotal' => Cart::instance('cart')->subtotal(),
        ]);
    }

    public function increase_item_quantity($rowId){
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId,$qty);
        return response()->json([
            'qty' => $qty,
            'cart_total' => Cart::instance('cart')->total(),
            'cart_subtotal' => Cart::instance('cart')->subtotal(),
            'row_subtotal' => Cart::instance('cart')->get($rowId)->subTotal()
        ]);
    }

    public function reduce_item_quantity($rowId){
        $product = Cart::instance('cart')->get($rowId);
        if (!$product) {
            return response()->json(['error' => 'Item not found'], 404);
        }
        $qty = $product->qty - 1;
        if ($qty <= 0) {
            Cart::instance('cart')->remove($rowId);
            return response()->json([
                'removed' => true,
                'cart_total' => Cart::instance('cart')->total(),
                'cart_subtotal' => Cart::instance('cart')->subtotal(),
                'count' => Cart::instance('cart')->count()
            ]);
        }
        Cart::instance('cart')->update($rowId, $qty);
        return response()->json([
            'qty' => $qty,
            'row_subtotal' => Cart::instance('cart')->get($rowId)->subTotal(),
            'cart_subtotal' => Cart::instance('cart')->subtotal(),
            'cart_total' => Cart::instance('cart')->total(),
            'count' => Cart::instance('cart')->count()
        ]);
    }

    public function remove_item_from_cart($rowId){
        Cart::instance('cart')->remove($rowId);
        return response()->json([
            'status' => 'success',
            'message' => 'Item removed',
            'sub_total' => Cart::instance('cart')->subtotal(),
            'count' => Cart::instance('cart')->count()
        ]);
    }

    public function empty_cart(){
        Cart::instance('cart')->destroy();
        return response()->json([
            'status' => 'success',
            'message' => 'Cart cleared',
            'sub_total' => Cart::instance('cart')->subtotal(),
            'count' => Cart::instance('cart')->count()
        ]);
    }

    public function checkout(){
        /* Check if user is logged in */
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        /* Check if an order was recently placed. this flag is set when an order (place.an.order) is placed successfully.
        It is destroyed  in the order confirmation view */
        if (session('order_placed', false)) {
            return redirect()->route('shop.index')->with('info', 'Your order has already been placed. Continue shopping!');
        }

        // Check if cart is empty
        if (Cart::instance('cart')->content()->isEmpty()) {
            return redirect()->route('shop.index')->with('info', 'Your cart is empty. Add items to continue.');
        }

        $user = Auth::user(); //get user instance
        $deliveryFees = DeliveryFee::with(['state', 'carrier'])->get();
        $address = Address::with('deliveryFee.state', 'deliveryFee.carrier')
            ->where('user_id', $user->id)
            ->where('isdefault', 1)
            ->first();
        return view('checkout', compact('address', 'user', 'deliveryFees'));
    }

/*     public function place_an_order(Request $request){
        $request->validate([
            'mode' => 'required|in:paystack',
        ]);

        $user_id = Auth::id();

        try {
            $order = DB::transaction(function () use ($request, $user_id) {
                $address = null;

                // Case 1: User has no existing address
                $existingAddress = Address::where('user_id', $user_id)->where('isdefault', true)->first();
                if (!$existingAddress) {
                    // Require address + delivery fee if no default address exists
                    $request->validate([
                        'address' => 'required|string|max:500',
                        'delivery_fee_id' => 'required|integer|exists:delivery_fees,id',
                    ]);

                    $address = new Address();
                    $address->user_id = $user_id;
                    $address->delivery_fee_id = $request->delivery_fee_id;
                    $address->address = $request->address;
                    $address->isdefault = true;
                    $address->save();
                }
                else {
                    // Case 2: If checkbox "different_shipping" is checked
                    if ($request->has('different_shipping')) {
                        $request->validate([
                            'address' => 'required|string|max:500',
                            'delivery_fee_id' => 'required|integer|exists:delivery_fees,id',
                        ]);

                        // Reset old defaults
                        Address::where('user_id', $user_id)->update(['isdefault' => false]);

                        // Save new address as default
                        $address = new Address();
                        $address->user_id = $user_id;
                        $address->delivery_fee_id = $request->delivery_fee_id;
                        $address->address = $request->address;
                        $address->isdefault = true;
                        $address->save();
                    } else {
                        // Case 3: Use existing default address without changes
                        $address = $existingAddress;
                    }
                }

                // Now we are guaranteed to have $address
                $deliveryFee = DeliveryFee::find($address->delivery_fee_id);
                $deliveryFeePrice = $deliveryFee ? $deliveryFee->price : 0;

                // ✅ Create order
                $order = new Order();
                $order->user_id = $user_id;
                $order->status = 'ordered';
                $order->is_shipping_different = $request->has('different_shipping');
                $order->save();

                // ✅ Process cart
                $subtotal = 0;
                $cartItems = Cart::instance('cart')->content();
                foreach ($cartItems as $item) {
                    $product = Product::find($item->id);
                    $price = $product->sale_price;

                    $orderItem = new OrderItem();
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $item->id;
                    $orderItem->price = $price;
                    $orderItem->quantity = $item->qty;
                    $orderItem->save();

                    $subtotal += $price * $item->qty;
                }

                // ✅ Finalize order totals
                $order->subtotal = $subtotal;
                $order->total = $subtotal + $deliveryFeePrice;
                $order->order_no = '1' . str_pad($order->id, 6, '0', STR_PAD_LEFT);
                $order->save();

                // ✅ Create transaction
                $transaction = new Transaction();
                $transaction->user_id = $user_id;
                $transaction->order_id = $order->id;
                $transaction->mode = $request->mode;
                $transaction->status = 'pending';
                $transaction->save();

                return $order;
            });

            Cart::instance('cart')->destroy();
            session()->forget('checkout');
            session()->put('order_placed', true);

            return redirect()->route('cart.order.confirmation', ['order' => $order->id])
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            \Log::error('Order placement failed: '.$e->getMessage());
            return redirect()->back()->with('error', 'Failed to place order: '.$e->getMessage());
        }
    } */

    public function place_an_order(Request $request){
        $request->validate([
            'delivery_fee_id' => 'required|exists:delivery_fees,id',
            'address' => 'required|string|max:500',
        ]);

        if (!Cart::instance('cart')->count()) {
            return response()->json(['message' => 'Cart is empty'], 422);
        }

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | HANDLE NEW ADDRESS CREATION IF DIFFERENT SHIPPING IS CHECKED
        |--------------------------------------------------------------------------
        */
    
        if ($request->different_shipping) {
    
            // Remove old default addresses
            Address::where('user_id', $user->id)
                ->update(['isdefault' => 0]);
    
            // Create brand new address
            Address::create([
                'user_id' => $user->id,
                'delivery_fee_id' => $request->delivery_fee_id,
                'address' => $request->address,
                'type' => 'home',
                'isdefault' => 1,
            ]);
        }
        
        $subtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
        $deliveryFee = DeliveryFee::findOrFail($request->delivery_fee_id);
        $total = $subtotal + $deliveryFee->price;

        $reference = 'PSTK_' . Str::upper(Str::random(10));

        $response = Http::withToken(config('services.paystack.secret_key'))
            ->post('https://api.paystack.co/transaction/initialize', [
                'email' => $user->email,
                'amount' => (int) ($total * 100),
                'reference' => $reference,
                'callback_url' => route('payment.callback'),
            ]);

        if (!$response->successful()) {
            return response()->json(['error' => 'Payment init failed'], 500);
        }

        Transaction::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'mode' => 'paystack',
            'paystack_reference' => $reference,
            'subtotal' => $subtotal,
            'delivery_fee' => $deliveryFee->price,
            'delivery_fee_id' => $deliveryFee->id,
            'amount' => $total,
            'cart_snapshot' => Cart::instance('cart')->content()->toArray(),
        ]);

        return response()->json([
            'authorization_url' => $response['data']['authorization_url'],
        ]);
    }


    public function payment_callback(Request $request){
        $reference = $request->query('reference');
        if (!$reference) {
            return redirect()->route('shop.index')
                ->with('error', 'No payment reference');
        }
        $transaction = Transaction::where('paystack_reference', $reference)
            ->where('status', 'approved')
            ->first();
        
        if ($transaction && $transaction->order_id && !$transaction->email_sent) {
            // ✅ Send Order Email
            Mail::to($transaction->user->email)
                ->send(new OrderPlacedMail($transaction));
            //To avoid duplicate emails (because callback can refresh), update this column:
            $transaction->update(['email_sent' => true]);
            // ✅ Clear cart AFTER confirmed payment
            Cart::instance('cart')->destroy();
            return redirect()->route('user.orders');
        }
        return view('payment-waiting', compact('reference'));
    }


    public function paystack_webhook(Request $request){
        $signature = $request->header('x-paystack-signature');
        $body = $request->getContent();
        if (!$signature || !hash_equals(
            hash_hmac('sha512', $body, config('services.paystack.secret_key')),
            $signature
        )) {
            return response('Invalid', 401);
        }
        $event = json_decode($body, true);
        if ($event['event'] !== 'charge.success') {
            return response('OK', 200);
        }
        $reference = $event['data']['reference'];
        // Fetch pending transaction
        $transaction = Transaction::where('paystack_reference', $reference)
            ->where('status', 'pending')
            ->first();

        if (!$transaction) {
            return response('OK', 200);
        }
        DB::transaction(function () use ($transaction, $event) {
            $cartItems = $transaction->cart_snapshot;
            if (is_string($cartItems)) {
                $cartItems = json_decode($cartItems, true);
            }
            // Create Order
            $order = Order::create([
                'user_id' => $transaction->user_id,
                'order_no' => 'ORD-' . strtoupper(Str::random(8)),
                'subtotal' => $transaction->subtotal,
                'total' => $transaction->amount,
                'status' => 'ordered',
            ]);
            // Create Order Items
            foreach ($cartItems as $item) {
                $product_id = $item['options']['product_id'];
                $size_id    = $item['options']['size_id'] ?? null;
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product_id,
                    'size_id'    => $size_id,
                    'price'      => $item['price'],
                    'quantity'   => $item['qty'],
                ]);
            }
            // 🔥 Update transaction explicitly
            $transaction->order_id = $order->id;
            $transaction->status = 'approved';
            $transaction->paystack_response = json_encode($event);
            $transaction->save(); // make sure it persists
        });
        return response('OK', 200);
    }

    public function set_amount_for_checkout(){ 
        if(!Cart::instance('cart')->count() > 0){
            session()->forget('checkout');
            return;
        }    
        session()->put('checkout',[
            'subtotal' => Cart::instance('cart')->subtotal(),
            'total' => Cart::instance('cart')->subtotal()
        ]);
    }

    public function order_confirmation(Request $request, $order){
        // Load the order with its items and address
        $order = Order::with('orderItems.product')->findOrFail($order);
        $address = Address::where('user_id', Auth::user()->id)->where('isdefault', true)->first();
        $deliveryFee = DeliveryFee::find($address->delivery_fee_id);
        // Clear the order_placed flag
        session()->forget('order_placed');
        return view('order-confirmation', compact('order', 'address', 'deliveryFee'));
    }

    public function get_delivery_fee(Request $request){
        $feeId = $request->get('delivery_fee_id');
        $fee = DeliveryFee::with(['state', 'carrier'])->find($feeId);
        $price = $fee ? $fee->price : 0;
        return response()->json(['price' => $price]);
    }
}
