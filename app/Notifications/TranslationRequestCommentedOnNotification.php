<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TranslationRequestCommentedOnNotification extends Notification
{
    use Queueable;

    public static function getTitle()
    {
        return __('Translation Request Commented On');
    }

    public static function getDescription()
    {
        return __("Get notified when someone comments on a translation request");
    }

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(private Comment $comment)
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
    public function toMail($notifiable)
    {
        $translationRequest = $this->comment->commentable;
        $source = $translationRequest->source;
        $commenter = $this->comment->author;

        $route = $commenter->id === $source->author_id
            ? route('translate', [$translationRequest->id, $source->slug]) // notifying the translator
            : route('translation', [$source->id, $translationRequest->language->id]); // notifying the author

        return (new MailMessage)
            ->subject('New Comment on Translation Request')
            ->line(
                __(':userName has left a comment on the :languageName translation request for :sourceTitle.', [
                    'userName' => '**' . $commenter->name . '**',
                    'languageName' => '**' . $translationRequest->language->name . '**',
                    'sourceTitle' => '**' . $translationRequest->source->title . '**',
                ])
            )
            ->line("_{$this->comment->truncatedText}_")
            ->action(
                __('View Translation Request'),
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
            'comment_id' => $this->comment->id,
        ];
    }
}
