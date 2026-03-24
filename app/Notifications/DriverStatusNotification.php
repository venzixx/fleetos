<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class DriverStatusNotification extends Notification
{
    public function __construct(
        public string $title,
        public string $body,
        public string $url = '/dashboard'
    ) {}

    public function via($notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification): WebPushMessage
    {
        return (new WebPushMessage)
            ->title($this->title)
            ->body($this->body)
            ->icon('/icons/icon-192.png')
            ->badge('/icons/icon-72.png')
            ->data(['url' => $this->url])
            ->action('Open App', 'open');
    }
}