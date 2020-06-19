<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WebPushNotification extends Notification
{

    use Queueable;

    protected $title = null;
    protected $body = null;
    protected $action = null;

    public function __construct($title, $body, $action)
    {
        $this->title = $title;
        $this->body  = $body;
        $this->action= $action;
    }

    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title($this->title)
            ->icon('/notification-icon.png')
            ->body($this->body)
            ->action('View', $this->action);
    }

}
