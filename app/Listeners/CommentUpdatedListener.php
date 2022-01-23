<?php

namespace App\Listeners;

use App\Events\CommentUpdatedEvent;
use App\Models\Comment;
use App\Models\TranslationRequest;
use App\Notifications\TranslationRequestCommentResolvedNotification;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;

class CommentUpdatedListener implements ShouldQueue
{
    use InteractsWithQueue;

    public int $tries = 3;

    private int $resolvedCommentBatchEmailIntervalInMinutes;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->resolvedCommentBatchEmailIntervalInMinutes = config('vl.notifications.resolved_comment_batch_interval', 30);
        $this->timeout = ($this->resolvedCommentBatchEmailIntervalInMinutes + 2) * 60;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CommentUpdatedEvent $event)
    {
        $comment = $event->comment;
        $commentable = $event->comment->commentable;
        $originalMetaData = $event->originalMetadata;

        if ($commentable instanceof TranslationRequest) {
            $this->handleTranslationRequestComment($comment, $commentable, $originalMetaData);
        }
    }

    private function handleTranslationRequestComment(Comment $comment, TranslationRequest $translationRequest, array $originalMetaData)
    {
        $wasResolved = Arr::get($originalMetaData, 'resolved_at', null) !== null;

        if ($comment->is_resolved && !$wasResolved) {
            $users = $translationRequest->reviewers;
            $users->add($translationRequest->source->author);

            if ($this->job->attempts() === 1) {
                $users->each->notify(
                    new TranslationRequestCommentResolvedNotification(collect([$comment]), false)
                );
            }

            $resolvedComments = $translationRequest
                ->comments()
                ->resolved()
                ->orderByResolveDate('desc')
                ->get();
            $latestResolvedComment = $resolvedComments->first();

            // Remove from the queue if it's not the latest resolved comment
            if (!$comment->is($latestResolvedComment)) {
                $this->delete();
                return;
            }

            $now = CarbonImmutable::now();
            $minutesSinceResolution = $comment->resolved_at->diffInMinutes();
            $minutesUntilNotification = $this->resolvedCommentBatchEmailIntervalInMinutes - $minutesSinceResolution;

            if ($minutesUntilNotification > 0) {
                // This accounts for leap seconds
                $numberOfSeconds = $now->addMinutes($minutesUntilNotification)->diffInSeconds($now);

                $this->release($numberOfSeconds);
                return;
            }

            $comments = collect();
            foreach ($resolvedComments as $i => $resolvedComment) {
                $comments->add($resolvedComment);

                if ($i === $resolvedComments->count() - 1) break;
                if ($resolvedComment->resolved_at->diffInMinutes($resolvedComments[$i + 1]->resolved_at) >= $this->resolvedCommentBatchEmailIntervalInMinutes) break;
            }

            $users->each->notify(
                new TranslationRequestCommentResolvedNotification($comments, true)
            );
        }
    }
}
