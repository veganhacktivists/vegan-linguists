<?php

namespace App\View\Components\Notifications;

use App\Models\TranslationRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\View\Component;

class TranslationRequestClaimRevoked extends Component
{
    public User $author;
    public TranslationRequest $translationRequest;
    public Carbon $date;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(DatabaseNotification $notification)
    {
        $this->translationRequest = TranslationRequest::where('id', $notification->data['translation_request_id'])
            ->with('source')
            ->first();
        $this->author = User::find($notification->data['author_id']);
        $this->date = $notification->created_at;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.notifications.translation-request-claim-revoked');
    }
}