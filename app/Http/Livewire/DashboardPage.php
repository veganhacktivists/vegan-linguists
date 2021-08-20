<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardPage extends Component
{
    public Collection $sources;
    public string $filter = 'all';

    public function mount() {
        $this->refreshSources();
    }

    public function render()
    {
        return view('livewire.dashboard-page');
    }

    public function changeFilter(string $filter) {
        $this->filter = $filter;
        $this->refreshSources();
    }

    private function refreshSources() {
        $this->sources = $this->getSources();
    }

    private function getSources() {
        return Auth::user()
            ->sources()
            ->with('translationRequests')
            ->when($this->filter === 'complete', function(Builder $query) {
                return $query->complete();
            })
            ->when($this->filter === 'incomplete', function(Builder $query) {
                return $query->incomplete();
            })
            ->orderByRecency()
            ->get();
    }
}
