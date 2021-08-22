<?php

namespace App\Http\Livewire;

use App\Models\TranslationRequest;
use App\Models\TranslationRequestStatus;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TranslatePage extends Component
{
    use AuthorizesRequests;

    public TranslationRequest $translationRequest;
    public string $translationContent;
    public string $translationPlainText;
    public bool $isConfirmingUnclaim = false;
    public bool $isConfirmingSubmission = false;

    public function mount(TranslationRequest $translationRequest, string $slug = '') {
        $this->authorize('view', $translationRequest);

        if ($slug !== $translationRequest->source->slug) {
            return redirect()->route('translate', [
                $translationRequest->id,
                $translationRequest->source->slug,
            ]);
        }

        $this->translationRequest = $translationRequest;
        $this->translationContent = $translationRequest->content;
        $this->translationPlainText = $translationRequest->plain_text;
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
        $this->authorize('view', $this->translationRequest);

        $this->isConfirmingUnclaim = false;
        $this->isConfirmingSubmission = false;

        $this->translationRequest->unclaim();
    }

    public function saveTranslation(string $content, string $plainText) {
        $this->authorize('view', $this->translationRequest);

        $this->translationContent = $content;
        $this->translationPlainText = $plainText;

        $this->translationRequest->update([
            'content' => $this->translationContent,
            'plain_text' => $this->translationPlainText,
        ]);

        $this->dispatchBrowserEvent('toast-translation-request-saved');
    }

    public function submitTranslation() {
        $this->authorize('view', $this->translationRequest);

        $this->validate();

        $this->translationRequest->update([
            'content' => $this->translationContent,
            'plain_text' => $this->translationPlainText,
            'status' => TranslationRequestStatus::COMPLETE,
        ]);

        session()->flash('flash.banner', __('Your translation has been submitted. Thank you for your contribution!'));

        return redirect()->route('queue');
    }

    protected function rules()
    {
        return [
            'translationContent' => ['required', 'string'],
            'translationPlainText' => ['required', 'string'],
        ];
    }
}
