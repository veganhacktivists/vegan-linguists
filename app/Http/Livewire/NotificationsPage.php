<?php

namespace App\Http\Livewire;

use App\Helpers\NotificationModelCache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationsPage extends Component
{
    public Collection $notifications;
    public Collection $unreadNotifications;

    public function mount()
    {
        $this->notifications = Auth::user()->notifications;
        $this->unreadNotifications = Auth::user()->unreadNotifications;
    }

    public function render()
    {
        return view('livewire.notifications-page', [
            'modelCache' => new NotificationModelCache($this->notifications),
        ]);
    }

    public function markAllAsRead()
    {
        $this->unreadNotifications->markAsRead();

        $this->unreadNotifications = Auth::user()->unreadNotifications;
        $this->notifications = Auth::user()->notifications;

        $this->emit('all-notifications-read');
    }
}
