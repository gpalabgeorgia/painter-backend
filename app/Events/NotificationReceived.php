<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;
    public $unreadCount;

    public function __with(Notification $notification)
    {
        $this->notification = $notification;
        // Считаем актуальное кол-во непрочитанных для этого юзера
        $this->unreadCount = Notification::where('customer_id', $notification->customer_id)
            ->where('is_read', false)
            ->count();
    }

    // Привязываем приватный канал конкретного покупателя
    public function broadcastOn()
    {
        return new PrivateChannel('customer.' . $this->notification->customer_id);
    }

    public function broadcastWith()
    {
        return [
            'unreadCount' => $this->unreadCount
        ];
    }
}
