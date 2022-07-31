<?php

namespace App\View\Components\Notifications;

use App\Helpers\NotificationModelCache;
use App\Models\Comment;
use App\Models\Source;
use App\Models\TranslationRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class TranslationRequestCommentResolved extends Component
{
    public Comment $comment;
    public Source $source;
    public TranslationRequest $translationRequest;
    public User $translator;

    public Carbon $date;
    public bool $isNotifyingAuthor;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        DatabaseNotification $notification,
        NotificationModelCache $modelCache
    ) {
        $this->comment = $modelCache->find(
            Comment::class,
            $notification->data['comment_id']
        );
        $this->translationRequest = $modelCache->find(
            TranslationRequest::class,
            $this->comment->commentable_id
        );
        $this->source = $modelCache->find(
            Source::class,
            $this->translationRequest->source_id
        );
        $this->translator = $modelCache->find(
            User::class,
            $this->translationRequest->translator_id
        );

        $this->date = $notification->created_at;

        $sourceAuthor = $modelCache->find(
            User::class,
            $this->source->author_id
        );
        $this->isNotifyingAuthor = $sourceAuthor->is(Auth::user());
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view(
            'components.notifications.translation-request-comment-resolved'
        );
    }
}
