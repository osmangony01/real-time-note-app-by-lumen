<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class NoteNotification extends Notification
{
    use Queueable;
    public $user;
    public $note;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $note)
    {
        $this->user = $user;
        $this->note = $note;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    // /**
    //  * Get the mail representation of the notification.
    //  *
    //  * @param  mixed  $notifiable
    //  * @return \Illuminate\Notifications\Messages\MailMessage
    //  */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->user['id'],
            'user_name' => $this->user['name'],
            'user_email' => $this->user['email'],
            'note_id' => $this->note['id'],
            'note_title' => $this->note['title'],
        ];
    }
}
