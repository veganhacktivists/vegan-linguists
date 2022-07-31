<?php

namespace App\View\Components\Notifications;

use App\Helpers\NotificationModelCache;
use App\Models\Source;
use App\Models\TranslationRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\View\Component;

class TranslationRequestClaimRevoked extends Component
{
    public User $author;
    public TranslationRequest $translationRequest;
    public Source $source;
    public Carbon $date;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        DatabaseNotification $notification,
        NotificationModelCache $modelCache
    ) {
        $this->translationRequest = $modelCache->find(
            TranslationRequest::class,
            $notification->data['translation_request_id']
        );
        $this->source = $modelCache->find(
            Source::class,
            $this->translationRequest->source_id
        );
        $this->author = $modelCache->find(
            User::class,
            $notification->data['author_id']
        );
        $this->date = $notification->created_at;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view(
            'components.notifications.translation-request-claim-revoked'
        );
    }
}
