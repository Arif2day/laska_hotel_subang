<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;
    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database']; // atau 'broadcast' kalau realtime
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Order baru dari meja {$this->order->table->table_name}",
            'order_id' => $this->order->id,
            'type'=>'Order Baru',
            'notifier'=>'tamu'

        ];
    }
}
