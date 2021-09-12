<?php

namespace App\Http\Livewire;

use App\Helpers\NotificationModelCache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationsPage extends Component
{
    public Collection $notifications;

    public function mount()
    {
        $this->notifications = Auth::user()->notifications;
    }

    public function render()
    {
        return view('livewire.notifications-page', [
            'modelCache' => new NotificationModelCache($this->notifications),
        ]);
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->emit('all-notifications-read');
    }
}
