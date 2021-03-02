<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\OrderUsers;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $orderitems, $orderuser)
    {
        $this->order = $order;
        $this->orderitems = $orderitems;
        $this->orderuser = $orderuser;
//       dd($orderitems);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.orders.new')
            ->subject('Новый заказ')
            ->with([
                'orderId' => $this->order->id,
                'orderTotal' => $this->order->total,
                'orderDateCreate' => $this->order->created_at,
                'orderitems' => $this->orderitems,
                'orderusers' => $this->orderuser,
            ]);
    }
}
