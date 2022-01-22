<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class TranslationRequestCommentResolvedNotification extends Notification implements BaseNotification, ShouldQueue
{
    use Queueable;

    public static function getTitle()
    {
        return __('Translation Comment Resolved');
    }

    public static function getDescription()
    {
        return __("Get notified when a translator resolves a comment on a translation");
    }

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(private Collection $comments, private bool $isBatched)
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

        if (!$this->isBatched && $notifiable->shouldBeNotified(static::class, 'site')) {
            $media[] = 'database';
        }

        if ($this->isBatched && $notifiable->shouldBeNotified(static::class, 'email')) {
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
        $translationRequest = $this->comments->first()->commentable;
        $source = $translationRequest->source;
        $translator = $translationRequest->translator;

        $route = $notifiable->id === $source->author_id
            ? route('translation', [$source->id, $translationRequest->language->id]) // notifying the author
            : route('translate', [$translationRequest->id, $source->slug, '#discussion']); // notifying a translator or reviewer

        $mail = (new MailMessage)
            ->subject(trans_choice('[1] Comment Resolved|[*] Comments Resolved', $this->comments->count()))
            ->line(
                __(':userName has resolved :numComments on the :languageName translation for :sourceTitle.', [
                    'userName' => '**' . $translator->name . '**',
                    'languageName' => '**' . $translationRequest->language->name . '**',
                    'sourceTitle' => '**' . $translationRequest->source->title . '**',
                    'numComments' => trans_choice('[1] a comment|[*] :count comments', $this->comments->count()),
                ])
            );

        foreach ($this->comments as $comment) {
            $mail->line("_{$comment->truncated_text}_");
        }

        $mail->action(
            __('View Translation Request'),
            $route,
        );

        return $mail;
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
            'comment_id' => $this->comments->first()->id,
        ];
    }
}
