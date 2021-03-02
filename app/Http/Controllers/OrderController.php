<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\OrderUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Cart;
use App\Helpers\Helper;
use Cache;
use Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;
use Yajra\Datatables\Facades\Datatables;
use App\DataTables\OrderItemsDataTable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Config;

//use NotificationChannels\WebPush\PushSubscription;

class OrderController extends Controller
{

    const STATUS_DRAFT = 0;
    const STATUS_NEW = 1;

    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    public function postOrder(Request $request)
    {


        $ordernew = new Order();

//        if (Auth::check()) {
        $user_id = Auth::user()->id;

        $name = Auth::user()->first_name;
        $email = Auth::user()->email;
        $phone = $request->phone;

//        } else {
//            $name = $request->first_name;
//            $email = $request->email;
//            $phone = $request->phone;
//            $user_id = 'guest';
//        }

        $adress = $request->adress;
        $cart_catalogs = Cart::instance('shopping')->content();


        //dd($cart_total);
        if (!$cart_catalogs) {

            return Redirect::route('index')->with('error', 'Your cart is empty.');
        }

        $ordernew->total = Cart::instance('shopping')->count();;
        $ordernew->order_users = $user_id;
        $ordernew->status = '0';
        $ordernew->save();
        $order_id = $ordernew->id;

        //     dd($name);

        $orderUser = new OrderUsers();
        $orderUser->order_id = $order_id;
        $orderUser->user_name = $name;
        $orderUser->user_email = $email;
        $orderUser->user_phone = $phone;
        $orderUser->user_adress = $adress;
        $orderUser->save();

        //dd($cart_catalogs);
        foreach ($cart_catalogs as $order_catalogs) {
            //dd($order_catalogs);
//            $catalog_price = Helper::CardItemPrice($order_catalogs->orig_number);
//            $catalog_ostatok = Helper::CardItemOstatok($order_catalogs->orig_number);

            //    dd($catalog_price);
            $ordernewitem = new OrderItems();
            $ordernewitem->order_id = $order_id;
            $ordernewitem->orig_number = $order_catalogs->options->number;
            $ordernewitem->title = $order_catalogs->name;
            $ordernewitem->amount = $order_catalogs->qty;
            $ordernewitem->price = $order_catalogs->total;
//            $ordernewitem->ostatok = $catalog_ostatok;
            $ordernewitem->save();

        }


        Cart::instance('shopping')->destroy();


        $data = [
            'Order_catalog' => $cart_catalogs,
        ];
        $order = Order::findOrFail($order_id);
        $orderitems = OrderItems::where('order_id', $order_id)->get();
        $orderuser = OrderUsers::where('order_id', $order_id)->get();

        $mail = Config::get('settings.contact_email');

        Mail::to($mail)->send(new OrderShipped($order, $orderitems, $orderuser));

        foreach ($orderuser as $user) {
            if ($user->user_email !== '') {
                Mail::to($user->user_email)->send(new OrderShipped($order, $orderitems, $orderuser));
            }
        }

        return redirect()->route('main')->with('message', 'Your order processed successfully.');

    }


    public function getIndex()
    {

        $users = User::All();
        $orders = Order::latest()->get();


        if (!$orders) {

            return Redirect::route('index')->with('error', 'There is no order.');
        }

        return View('admin.orders.index', compact('orders', 'users'));

    }


    public function getOrder()
    {


        return View('vendor.backpack.order.index');

    }

    public function getOrderItems()
    {
//        $orderUser = new OrderUsers();
        $orders = Order::select(['id', 'order_users', 'total', 'status', 'created_at'])->get();
//
        return Datatables::of($orders)
            ->editColumn('status', function ($order) {
//                dd($status);
                if ($order->status == '0') {
                    $status = 'Новый';
                } elseif ($order->status == '1') {
                    $status = 'В работе';
                } elseif ($order->status == '2') {
                    $status = 'Закрыт';
                } else $status = 'Отказ';

                return $status;
            })
            ->addColumn('details_url', function ($order) {
                return url('/admin/order/data/' . $order->id);
            })
            ->addColumn('action', function ($order) {
                return '<a href="order/edit/' . $order->id . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i>Просмотр/изменение</a>
                             <a href="order/delete/' . $order->id . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Удалить</a>';
            })
            ->make(true);

    }

    public function getOrderItemsData($id)
    {

        $OrderItems = Order::find($id)->OrderItems();

        return Datatables::of($OrderItems)->make(true);


    }

    public function getEditOrder($id)
    {
        $order = Order::findOrFail($id);
        $orderitems = OrderItems::where('order_id', $id)->get();
        $orderuser = OrderUsers::where('order_id', $id)->get();

        return View('vendor.backpack.order.edit', compact('order', 'orderitems', 'orderuser'));
    }


    public function postEditStatus($id)
    {
        $status = Input::get('value');
        $statusData = Order::whereId($id)->first();
        $statusData->status = $status;
        if ($statusData->save())
            return $status;
        else
            return 'bad';
    }

    public function postEditPrice($id)
    {
        $price = Input::get('value');
        $priceData = OrderItems::whereId($id)->first();
        $priceData->price = $price;
        $priceData->total = $price * $priceData->amount;
        if ($priceData->save()) {
            $this->OrderTotal($priceData->order_id);
            return $price;
        } else
            return 'bad';
    }

    public function postEditAmount($id)
    {
        $amount = Input::get('value');
        $amountData = OrderItems::whereId($id)->first();
        $amountData->amount = $amount;
        $amountData->total = $amount * $amountData->price;
        if ($amountData->save()) {
            $this->OrderTotal($amountData->order_id);
            return $amount;
        } else
            return 'bad';
    }

    public function getDeleteOrder($id)
    {
        $order = Order::find($id);
        $order->delete();
        return redirect()->back();

    }

    public function OrderTotal($order_id)
    {
        $total = 0;
        $OrderUp = Order::whereId($order_id)->first();
        $OrderTotalItemUp = OrderItems::where('order_id', $OrderUp->id)->get();
        foreach ($OrderTotalItemUp as $item) {
            $total = $total + $item->total;
        }
        $OrderUp->total = $total;
        $OrderUp->save();
    }

}

