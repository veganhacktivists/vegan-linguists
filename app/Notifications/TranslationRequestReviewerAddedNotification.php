<?php

namespace App\Notifications;

use App\Models\TranslationRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TranslationRequestReviewerAddedNotification extends Notification implements BaseNotification, ShouldQueue
{
    use Queueable;

    public static function getTitle()
    {
        return __('Translation Under Review');
    }

    public static function getDescription()
    {
        return __("Get notified when someone starts reviewing a translation request");
    }

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(private TranslationRequest $translationRequest, private User $reviewer)
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
        $media = [];

        if ($notifiable->shouldBeNotified(static::class, 'site')) {
            $media[] = 'database';
        }

        if ($notifiable->shouldBeNotified(static::class, 'email')) {
            $media[] = 'mail';
        }

        return $media;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(User $notifiable)
    {
        $source = $this->translationRequest->source;

        $route = $notifiable->id === $source->author_id
            ? route('translation', [$source->id, $this->translationRequest->language->id]) // notifying the author
            : route('translate', [$this->translationRequest->id, $source->slug]); // notifying translator

        return (new MailMessage)
            ->subject(__('New Reviewer on Translation'))
            ->line(
                __(':userName has started reviewing the :languageName translation for :sourceTitle.', [
                    'userName' => '**' . $this->reviewer->name . '**',
                    'languageName' => '**' . $this->translationRequest->language->name . '**',
                    'sourceTitle' => '**' . $this->translationRequest->source->title . '**',
                ])
            )
            ->action(
                __('View Translation'),
                $route,
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
            'translation_request_id' => $this->translationRequest->id,
            'reviewer_id' => $this->reviewer->id,
        ];
    }
}
