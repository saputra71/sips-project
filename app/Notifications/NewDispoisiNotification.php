<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\IngoingMail;
use App\Models\User;

class NewDispoisiNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    // public function __construct(IngoingMail $mail)
    // {
    //     $this->mail = $mail;
    // }

    public function __construct($ingoingMail, $status, $kepada, $catatan, $authUser)
    {
        $this->ingoingMail = $ingoingMail;
        $this->status = $status;
        $this->kepada = $kepada;
        $this->catatan = $catatan;
        $this->authUser = $authUser;
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

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->ingoingMail->id,
            'nomor_surat' => $this->ingoingMail->nomor_surat,
            'status' => $this->status,
            // 'kepada' => $this->kepada,
            'kepada' => User::find($this->kepada)->name,
            'catatan' => $this->catatan,
            'message' => 'Surat masuk baru telah ditambahkan oleh ' . $this->authUser->name . ' - ' . $this->authUser->roles->first()->name,
            'type' => 'Disposisi',
        ];
    }
}
