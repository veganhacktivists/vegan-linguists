<?php

namespace App\Livewire;

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

    public bool $isConfirmingTranslationRequestDeletion = false;

    public bool $isConfirmingSourceDeletion = false;

    public function mount(
        Source $source,
        TranslationRequest $translationRequest,
        string $slug = ''
    ) {
        $this->authorize('view', $source);

        $this->source = $source;
        $this->isViewingTranslation = isset($translationRequest->id);
        $this->currentTranslationRequest = $translationRequest;

        if (! $this->isViewingTranslation && $slug !== $source->slug) {
            return redirect()->route('source', [$source->id, $source->slug]);
        }
    }

    public function render()
    {
        return view('livewire.source-page');
    }

    public function revokeClaim()
    {
        $this->authorize('view', $this->source);

        $translatorName = $this->currentTranslationRequest->translator->name;
        $this->currentTranslationRequest->unclaim();

        session()->flash(
            'flash.banner',
            __('Revoked :translatorName\'s claim.', [
                'translatorName' => $translatorName,
            ])
        );

        return redirect()->route('translation', [
            $this->source->id,
            $this->currentTranslationRequest->language->id,
        ]);
    }

    public function deleteSource()
    {
        $this->authorize('delete', $this->source);

        session()->flash(
            'flash.banner',
            __('Deleted :sourceTitle.', [
                'sourceTitle' => $this->source->title,
            ])
        );

        $this->source->delete();

        return redirect()->route('home');
    }

    public function deleteTranslationRequest()
    {
        $this->authorize('delete', $this->source);

        session()->flash(
            'flash.banner',
            __(
                'The :languageName translation of ":sourceTitle" has been deleted.',
                [
                    'languageName' => $this->currentTranslationRequest->language->name,
                    'sourceTitle' => $this->source->title,
                ]
            )
        );

        $this->currentTranslationRequest->delete();

        return redirect()->route('source', [
            $this->source->id,
            $this->source->slug,
        ]);
    }
}
