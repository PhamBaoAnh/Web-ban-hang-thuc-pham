<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Mailorder extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $cart;

    public function __construct($data)
    {
        $this->order = $data['order'];
        $this->cart = $data['cart'];
    }

 public function build()
{
    return $this->view('Frontend.email.mailorder')
                ->subject('Thông báo đơn hàng') // Chủ đề của email
                ->with([
                    'order' => $this->order,
                    'created_at' => $this->order->created_at, 
                     'cart' => $this->cart,// Thêm created_at vào dữ liệu gửi đi
                ]);
}

}



