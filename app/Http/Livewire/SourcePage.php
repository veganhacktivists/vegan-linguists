<?php

namespace App\Http\Livewire;

use App\Models\Source;
use App\Models\TranslationRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class SourcePage extends Component
{
    use AuthorizesRequests;

    public Source $source;
    public TranslationRequest $currentTranslationRequest;
    public bool $isViewingTranslation;
    public bool $isConfirmingClaimRevocation = false;

    public function mount(
        Source $source,
        TranslationRequest $translationRequest,
        string $slug = ''
    ) {
        $this->authorize('view', $source);

        $this->source = $source;
        $this->isViewingTranslation = isset($translationRequest->id);
        $this->currentTranslationRequest = $translationRequest;

        if (!$this->isViewingTranslation && $slug !== $source->slug) {
            return redirect()->route('source', [$source->id, $source->slug]);
        }
    }

    public function render()
    {
        return view('livewire.source-page');
    }

    public function revokeClaim()
    {
        $this->currentTranslationRequest->unclaim();
        $this->isConfirmingClaimRevocation = false;
        $this->source->refresh();
    }
}
