<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DailySalesSummaryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public array $summary,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Daily sales summary')
            ->line('Orders: '.$this->summary['orders_count'])
            ->line('Units sold: '.$this->summary['units_sold'])
            ->line('Revenue: $'.number_format($this->summary['revenue'], 2));
    }

    public function toArray(object $notifiable): array
    {
        return $this->summary;
    }
}
