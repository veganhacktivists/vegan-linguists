<?php

namespace App\Helpers;

use App\Models\Comment;
use App\Models\Source;
use App\Models\TranslationRequest;
use App\Models\User;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Collection;

class NotificationModelCache
{
    private Collection $comments;
    private Collection $sources;
    private Collection $translationRequests;
    private Collection $users;

    public function __construct(DatabaseNotificationCollection $notifications)
    {
        $commentIds = $this->pluckCommentIds($notifications)->unique();
        $this->comments = Comment::whereIn('id', $commentIds)
            ->get()
            ->keyBy('id');

        $translationRequestIds = $this->pluckTranslationRequestIds($notifications)
            ->concat(
                $this->comments->where('commentable_type', TranslationRequest::class)
                    ->pluck('commentable_id')
            )
            ->unique();
        $this->translationRequests = TranslationRequest::whereIn('id', $translationRequestIds)
            ->get()
            ->keyBy('id');

        $sourceIds = $this->pluckSourceIds($notifications)
            ->concat($this->translationRequests->pluck('source_id'))
            ->unique();
        $this->sources = Source::whereIn('id', $sourceIds)
            ->get()
            ->keyBy('id');

        $userIds = $this->pluckUserIds($notifications)
            ->concat($this->comments->pluck('author_id'))
            ->concat($this->sources->pluck('author_id'))
            ->concat($this->translationRequests->pluck('translator_id'))
            ->unique();
        $this->users = User::whereIn('id', $userIds)
            ->get()
            ->concat([User::deletedUser()])
            ->keyBy('id');
    }

    public function find(string $model, int|null $id)
    {
        $collection = (function () use ($model) {
            switch ($model) {
                case Comment::class:
                    return $this->comments;
                case Source::class:
                    return $this->sources;
                case TranslationRequest::class:
                    return $this->translationRequests;
                case User::class:
                    return $this->users;
                default:
                    return collect();
            }
        })();

        $record = $collection->get($id);
        if (!$record) {
            return $model::find($id);
        }

        return $record;
    }

    private function pluckCommentIds(DatabaseNotificationCollection $notifications)
    {
        return $notifications->pluck('data.comment_id')->filter();
    }

    private function pluckSourceIds(DatabaseNotificationCollection $notifications)
    {
        return $notifications->pluck('data.source_id')->filter();
    }

    private function pluckTranslationRequestIds(DatabaseNotificationCollection $notifications)
    {
        return $notifications->pluck('data.translation_request_id')->filter();
    }

    private function pluckUserIds(DatabaseNotificationCollection $notifications)
    {
        return $notifications->pluck('data.translator_id')
            ->concat($notifications->pluck('data.author_id'))
            ->concat($notifications->pluck('data.reviewer_id'))
            ->filter();
    }
}
