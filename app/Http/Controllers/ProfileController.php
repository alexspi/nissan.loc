<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 16.08.2016
 * Time: 18:19
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\View\View;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Validator;
use Mail;
use Storage;
use CurlHttp;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\User;


class ProfileController extends Controller
{
    public function mainIndex()
    {

        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $first_name = Auth::user()->first_name;
            $second_name = Auth::user()->last_name;
            $email = Auth::user()->email;
            $phone = Auth::user()->phone;
            $active = Auth::user()->activated;

        } else {
            return redirect()->route('home')->with('message', 'У вас нет прав доступа.');
        }


        $orders = Order::where('order_users', $user_id)->get();
//        dd($orders);
        $count =$orders->count();
        if ($count != 0) {

            $message = "У вас ".$count." заказов";
            foreach ($orders as $order) {
                if ($order->status == '0') {
                    $status = 'Новый';
                    $style = 'red';
                } elseif ($order->status == '1') {
                    $status = 'В работе';
                    $style = 'green';
                } elseif ($order->status == '2') {
                    $status = 'Закрыт';
                    $style = 'blue';
                } else $status = 'Отказ';
                $style = 'red';

                $orderItems[] = ['data' => date_format($order->created_at, 'd-m-Y'), 'id' => $order->id, 'status' => $order->status, 'style' => $style, Order::find($order->id)->OrderItems()->get()];
            }
//        dump(collect($orderItems));
            return view('auth.profile.home', compact('first_name', 'second_name', 'email', 'phone', 'user_id', 'active', 'orderItems', 'orders','message','count'));
        }
        $orderItems = [];
        $orders=null;
        $message = "У вас ещё нет заказов";
        return view('auth.profile.home', compact('first_name', 'second_name', 'email', 'phone', 'user_id', 'active', 'orderItems', 'orders','message','count'));
    }


    public function canselOrder($id)
    {

        $Order = Order::where('id', $id)->first();

        $Order->status = '3';
        $Order->save();
        return redirect()->back();

    }

    public function getDeleteOrder($id)
    {
        $order = Order::find($id);
        $order->delete();
        return redirect()->back();

    }


}