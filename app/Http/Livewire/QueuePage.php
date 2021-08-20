<?php

namespace App\Http\Livewire;

use App\Models\TranslationRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class QueuePage extends Component
{
    public Collection $claimedTranslationRequests;
    public Collection $translationRequests;
    public Collection $languages;
    public int $sourceLanguageFilter = -1;
    public int $targetLanguageFilter = -1;

    public function mount() {
        $this->languages = Auth::user()->languages;
        $this->claimedTranslationRequests = Auth::user()
            ->translationRequests()
            ->with('source', 'source.author', 'source.language')
            ->get();
        $this->refreshTranslationRequests();
    }

    public function render()
    {
        return view('livewire.queue-page');
    }

    public function refreshTranslationRequests() {
        $this->translationRequests = $this->getTranslationRequests();
    }

    private function getTranslationRequests() {
        return TranslationRequest::query()
            ->with('source', 'source.author', 'source.language')
            ->unclaimed()
            ->excludingSourceAuthor(Auth::user())
            ->whereSourceLanguageId(
                $this->sourceLanguageFilter === -1
                ? $this->languages->pluck('id')
                : $this->sourceLanguageFilter
            )
            ->whereLanguageId(
                $this->targetLanguageFilter === -1
                ? $this->languages->pluck('id')
                : $this->targetLanguageFilter
            )
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
