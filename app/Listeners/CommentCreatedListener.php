<?php

namespace App\Listeners;

use App\Events\CommentCreatedEvent;
use App\Models\Comment;
use App\Models\TranslationRequest;
use App\Notifications\TranslationRequestCommentedOnNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CommentCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  CommentCreatedEvent  $event
     * @return void
     */
    public function handle(CommentCreatedEvent $event)
    {
        $comment = $event->comment;
        $commentable = $event->comment->commentable;

        if ($commentable instanceof TranslationRequest) {
            $this->handleTranslationRequestComment($comment, $commentable);
        }
    }

    private function handleTranslationRequestComment(Comment $comment, TranslationRequest $translationRequest)
    {
        if ($comment->author_id === $translationRequest->translator_id) {
            $translationRequest->source->author->notify(new TranslationRequestCommentedOnNotification($comment));
        } elseif ($translationRequest->translator_id) {
            $translationRequest->translator->notify(new TranslationRequestCommentedOnNotification($comment));
        }
    }
}
