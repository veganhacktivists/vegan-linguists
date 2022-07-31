<?php

namespace App\Http\Livewire;

use App\Helpers\NotificationModelCache;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class NotificationsPage extends Component
{
    use WithPagination;

    const NUM_NOTIFICATIONS_PER_PAGE = 20;

    public Collection $unreadNotifications;

    protected $queryString = [
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->unreadNotifications = Auth::user()->unreadNotifications;
    }

    public function render()
    {
        $notifications = Auth::user()
            ->notifications()
            ->paginate(self::NUM_NOTIFICATIONS_PER_PAGE);

        return view('livewire.notifications-page', [
            'notifications' => $notifications,
            'modelCache' => new NotificationModelCache(
                $notifications->getCollection()
            ),
        ]);
    }

    public function markAllAsRead()
    {
        if (
            $this->unreadNotifications instanceof DatabaseNotificationCollection
        ) {
            $this->unreadNotifications->markAsRead();
        }

        $this->unreadNotifications = Auth::user()->unreadNotifications;

        $this->emit('all-notifications-read');
    }
}
