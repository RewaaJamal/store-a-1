<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Cart;
use App\Models\User;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewOrderNotification;

class OrdersController extends Controller
{
    public function index()
    {
        return view('orders',[
            'orders'=> Auth::user()->orders,
        ]);
    }

    public function checkout()
    {
        $user = Auth::user();
        $products = $user->cartProducts;
        if(! $products){
            return redirect()->route('home');
        }
        DB::beginTransaction();
        try{
            $order = $user->orders()->create([
                'status' =>'pending',
            ]);
            foreach($products as $product){
                OrderProduct::create([
                    'order_id'=>$order->id,
                    'product_id'=> $product->id,
                    'price' => $product->price,
                    'quantity'=> $product->pivot->quantity,
                ]);
            }
            
            //Cart::where('user_id', $user->id)->delete();
            
            //Notify the admin
            $admin = User::where('type','super-admin')->first();
            $admin->notify(new NewOrderNotification);

            DB::commit();
        } catch (Throwable $e){
            DB::rollBack();
            return redirect()->route('cart.index');
        
        }
        return redirect()->route('cart.index');
        
    }


}
