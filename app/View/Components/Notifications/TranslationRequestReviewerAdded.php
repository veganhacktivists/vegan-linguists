<?php

namespace App\View\Components\Notifications;

use App\Helpers\NotificationModelCache;
use App\Models\Source;
use App\Models\TranslationRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class TranslationRequestReviewerAdded extends Component
{
    public Source $source;
    public TranslationRequest $translationRequest;
    public User $reviewer;

    public Carbon $date;
    public bool $isNotifyingAuthor;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(DatabaseNotification $notification, NotificationModelCache $modelCache)
    {
        $this->translationRequest = $modelCache->find(TranslationRequest::class, $notification->data['translation_request_id']);
        $this->source = $modelCache->find(Source::class, $this->translationRequest->source_id);
        $this->reviewer = $modelCache->find(User::class, $notification->data['reviewer_id']);
        $this->date = $notification->created_at;

        $sourceAuthor = $modelCache->find(User::class, $this->source->author_id);
        $this->isNotifyingAuthor = $sourceAuthor->is(Auth::user());
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.notifications.translation-request-reviewer-added');
    }
}
