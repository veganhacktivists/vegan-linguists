<?php

namespace App\Notifications;

use App\Models\TranslationRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClaimedTranslationRequestDeletedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(private string $translationRequestTitle, private string $languageName)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
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
            ->subject(__('Translation Request Deleted'))
            ->line(
                __('The :languageName translation request for :sourceTitle has been deleted.', [
                    'languageName' => '**' . $this->languageName . '**',
                    'sourceTitle' => '**' . $this->translationRequestTitle . '**',
                ])
            )
            ->action(
                __('View Your Claimed Translation Requests'),
                route('home')
            );
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
            'translation_request_title' => $this->translationRequestTitle,
            'language_name' => $this->languageName,
        ];
    }
}
