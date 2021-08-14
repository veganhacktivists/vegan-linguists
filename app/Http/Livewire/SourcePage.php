<?php

namespace App\Http\Livewire;

use App\Models\Source;
use App\Models\TranslationRequest;
use Livewire\Component;

class SourcePage extends Component
{
    public Source $source;
    public string $content;
    public bool $isViewingTranslation;

    public function mount(
        Source $source,
        TranslationRequest $translationRequest,
        string $slug = ''
    ) {
        $this->source = $source;
        $this->content = $source->content;
        $this->isViewingTranslation = isset($translationRequest->id);

        if ($this->isViewingTranslation) {
            $this->content = $translationRequest->content;
        } else if ($slug !== $source->slug) {
            return redirect()->route('source', [$source->id, $source->slug]);
        }
    }

    public function render()
    {
        return view('livewire.source-page');
    }
}
