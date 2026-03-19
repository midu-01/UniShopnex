<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlacedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Order $order,
        public string $audience = 'customer',
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Order '.$this->order->order_number.' received')
            ->greeting('Hello '.$notifiable->name.',')
            ->line('Order '.$this->order->order_number.' has been recorded for '.$this->audience.'.')
            ->action('View order', url('/dashboard'))
            ->line('Thank you for shopping with UniShopnex.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'audience' => $this->audience,
            'total_amount' => $this->order->total_amount,
        ];
    }
}
