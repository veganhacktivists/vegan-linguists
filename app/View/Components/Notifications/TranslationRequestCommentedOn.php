<?php

namespace App\View\Components\Notifications;

use App\Helpers\NotificationModelCache;
use App\Models\Comment;
use App\Models\Source;
use App\Models\TranslationRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\View\Component;

class TranslationRequestCommentedOn extends Component
{
    public Comment $comment;
    public Source $source;
    public TranslationRequest $translationRequest;
    public User $commentAuthor;

    public Carbon $date;
    public bool $isNotifyingAuthor;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(DatabaseNotification $notification, NotificationModelCache $modelCache)
    {
        $this->comment = $modelCache->find(Comment::class, $notification->data['comment_id']);
        $this->translationRequest = $modelCache->find(TranslationRequest::class, $this->comment->commentable_id);
        $this->source = $modelCache->find(Source::class, $this->translationRequest->source_id);
        $this->commentAuthor = $modelCache->find(User::class, $this->comment->author_id);

        $this->date = $notification->created_at;

        $sourceAuthor = $modelCache->find(User::class, $this->source->author_id);
        $this->isNotifyingAuthor = !$this->commentAuthor->is($sourceAuthor);
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
