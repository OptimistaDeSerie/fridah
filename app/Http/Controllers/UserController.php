<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\Address;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return view("user.index");
    }

    public function orders(){
        $orders = Order::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(12);
        return view('user.orders',compact('orders'));
    }

    public function order_details($order_id){
        $order = Order::where('user_id',Auth::user()->id)->find($order_id);        
        $orderItems = OrderItem::where('order_id',$order_id)->orderBy('id')->paginate(12);
        $transaction = Transaction::where('order_id',$order_id)->first();
        return view('user.order-details',compact('order','orderItems','transaction'));
    }

    public function addresses(){
        $addresses = Address::where('user_id', Auth::id())
            ->with('deliveryFee.state', 'deliveryFee.carrier')
            ->orderByDesc('isdefault')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.addresses', compact('addresses'));
    }

    /**
     * Set a specific address as the default for the authenticated user
     */
    public function set_default_address(Address $address){
        // Security check: Ensure the address belongs to the logged-in user
        if ((int) $address->user_id !== (int) Auth::id()) {
            abort(403);
        }

        // Start a database transaction for safety
        DB::transaction(function () use ($address) {
            // Remove default status from all other addresses of this user
            Address::where('user_id', Auth::id())
                ->where('id', '!=', $address->id)
                ->update(['isdefault' => 0]);

            // Set the selected address as default
            $address->update(['isdefault' => 1]);
        });

        return redirect()->route('user.addresses')->with('success', 'Default address updated successfully!');
    }

    /* public function cancel_order(Request $request){
        $order = Order::find($request->order_id);
        $order->status = 'canceled';
        $order->canceled_date = Carbon::now();
        $order->save();
        return back()->with('status', 'Order has been cancelled successfully!');
    } */
}
