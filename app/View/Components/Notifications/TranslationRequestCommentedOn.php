<?php

namespace App\View\Components\Notifications;

use App\Models\Comment;
use App\Models\TranslationRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\View\Component;

class TranslationRequestCommentedOn extends Component
{
    public Comment $comment;
    public TranslationRequest $translationRequest;
    public Carbon $date;
    public bool $isNotifyingAuthor;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(DatabaseNotification $notification)
    {
        $this->comment = Comment::where('id', $notification->data['comment_id'])
            ->with('commentable', 'author', 'commentable.source', 'commentable.source.author')
            ->first();

        $this->translationRequest = $this->comment->commentable;
        $this->date = $notification->created_at;

        $this->isNotifyingAuthor = !$this->comment->author->is($this->translationRequest->source->author);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.notifications.translation-request-commented-on');
    }
}
