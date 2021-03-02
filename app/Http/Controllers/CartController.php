<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\PrsoProduct;
//use App\Models\Cart;
use Illuminate\Session\SessionManager;
use App\Http\Requests;
use Redirect;
use View;
//use Guzzle\Plugin\Cookie\Cookie;
use Cache;
use App\Models\User;
use Cart;

class CartController extends Controller

{


    public function postAddToCart(Request $request)
    {

        $catalog = PrsoProduct::where('number', $request->orignumber)->first();
//dump($catalog,$request->all());
        if($catalog !== null) {
            Cart::instance('shopping')->add($catalog->id, $catalog->name, $request->amount, $catalog->price, ['number' => $catalog->number]);
        }else{
            Cart::instance('shopping')->add($request->number, $request->title, $request->amount, .0, ['number' => $request->orignumber]);
        }
        if (Auth::check()) {

            $user_id = Auth::id();

            Cart::instance('shopping')->restore($user_id);

        }

//

        return redirect()->back();
    }


    public function getIndex()
    {
        return View('cart');
    }

    public function getDelete($id)
    {
        Cart::instance('shopping')->remove($id);

        return Redirect::route('cart');
    }

}