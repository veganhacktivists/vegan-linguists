<?php

namespace App\Http\Livewire;

use App\Models\TranslationRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TranslatePage extends Component
{
    use AuthorizesRequests;

    public TranslationRequest $translationRequest;

    public function mount(TranslationRequest $translationRequest, string $slug = '') {
        $this->authorize('view', $translationRequest);

        if ($slug !== $translationRequest->source->slug) {
            return redirect()->route('translate', [
                $translationRequest->id,
                $translationRequest->source->slug,
            ]);
        }

        $this->translationRequest = $translationRequest;
    }

    public function render()
    {
        return view('livewire.translate-page');
    }

    protected $listeners = ['claimTranslationRequest', 'unclaimTranslationRequest'];

    public function claimTranslationRequest() {
        $this->authorize('claim', $this->translationRequest);

        $this->translationRequest->assignTo(Auth::user());
    }

    public function unclaimTranslationRequest() {
        $this->translationRequest->unclaim();
    }
}
