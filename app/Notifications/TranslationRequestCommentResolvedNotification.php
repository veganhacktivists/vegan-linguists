<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Collection;

class TranslationRequestCommentResolvedNotification extends BaseNotification implements ShouldQueue
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

    public function __construct(private Collection $comments, private bool $isBatched)
    {
    }

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
            __('View translation request'),
            $route,
        );

        return $mail;
    }

    public function toArray(User $notifiable)
    {
        return [
            'comment_id' => $this->comments->first()->id,
        ];
    }
}
