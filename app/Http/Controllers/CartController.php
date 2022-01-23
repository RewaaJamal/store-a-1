<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return $user->cartProducts;
        /*return view ('cart',[
            'products'=> $user->cartProducts,
        ]);*/
    }
     
    public function store(Request $request)
    {
        $user = Auth::user();
        Cart::create([
            'user_id'=> $user->id,
            'product_id'=> $request->post('product_id'),
            'quantity'=> $request->post('quantity',1),

        ]);
        return redirect()->route('cart.index');
    }

    public function destroy($product_id)
    {
        $user = Auth::user();
        Cart::where([
            'user_id'=> $user->id,
            'product_id'=> $product_id,
        ])->delete();
        return redirect()->route('cart.index');

    }

}

