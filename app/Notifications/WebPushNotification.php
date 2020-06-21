<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WebPushNotification extends Notification implements ShouldQueue
{

    use Queueable;

    protected $title = null;
    protected $body = null;
    protected $action = null;
    protected $action_button = null;

    public function __construct($title, $body,$action_button, $action)
    {
        $this->title = $title;
        $this->body  = $body;
        $this->action= $action;
        $this->action_button= $action_button;
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
            ->action($this->action_button, $this->action);
    }

}
