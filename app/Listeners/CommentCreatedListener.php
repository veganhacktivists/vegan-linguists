<?php

namespace App\Listeners;

use App\Events\CommentCreatedEvent;
use App\Models\Comment;
use App\Models\TranslationRequest;
use App\Notifications\TranslationRequestCommentedOnNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentCreatedListener implements ShouldQueue
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
        $users = $translationRequest
            ->reviewers()
            ->where('users.id', '<>', $comment->author_id)
            ->get();

        if ($comment->author_id !== $translationRequest->source->author_id) {
            $users->add($translationRequest->source->author);
        }

        if ($comment->author_id !== $translationRequest->translator_id) {
            $users->add($translationRequest->translator);
        }

        foreach ($users as $user) {
            $user->notify(new TranslationRequestCommentedOnNotification($comment));
        }
    }
}
