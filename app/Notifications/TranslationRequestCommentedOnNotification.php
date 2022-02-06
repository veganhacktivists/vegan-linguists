<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TranslationRequestCommentedOnNotification extends BaseNotification implements ShouldQueue
{
    use Queueable;

    public static function getTitle()
    {
        return __('Translation Commented On');
    }

    public static function getDescription()
    {
        return __("Get notified when someone comments on a translation");
    }

    public function __construct(private Comment $comment)
    {
    }

    public function toMail(User $notifiable)
    {
        $translationRequest = $this->comment->commentable;
        $source = $translationRequest->source;
        $commenter = $this->comment->author;

        $route = $notifiable->id === $source->author_id
            ? route('translation', [$source->id, $translationRequest->language->id]) // notifying the author
            : route('translate', [$translationRequest->id, $source->slug, '#discussion']); // notifying a translator or reviewer

        return (new MailMessage)
            ->subject(__('New Comment on Translation'))
            ->line(
                __(':userName has left a comment on the :languageName translation for :sourceTitle.', [
                    'userName' => '**' . $commenter->name . '**',
                    'languageName' => '**' . $translationRequest->language->name . '**',
                    'sourceTitle' => '**' . $translationRequest->source->title . '**',
                ])
            )
            ->line("_{$this->comment->truncated_text}_")
            ->action(
                __('View translation request'),
                $route,
            );
    }

    public function toArray(User $notifiable)
    {
        return [
            'comment_id' => $this->comment->id,
        ];
    }
}
