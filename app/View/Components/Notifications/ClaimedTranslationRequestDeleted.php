<?php

namespace App\View\Components\Notifications;

use Carbon\Carbon;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\View\Component;

class ClaimedTranslationRequestDeleted extends Component
{
    public string $translationRequestTitle;
    public Carbon $date;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(DatabaseNotification $notification)
    {
        $this->translationRequestTitle = $notification->data['translation_request_title'];
        $this->date = $notification->created_at;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.notifications.claimed-translation-request-deleted');
    }
}
