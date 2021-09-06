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
    public bool $isConfirmingClaim = false;
    public bool $isConfirmingUnclaim = false;
    public bool $isConfirmingSubmission = false;
    public bool $isMine;

    protected $listeners = ['toggleClaimModal', 'toggleSubmissionModal', 'toggleUnclaimModal'];

    public function mount(TranslationRequest $translationRequest, string $slug = '')
    {
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
        $this->isMine = $translationRequest->isClaimedBy(Auth::user());

    }

    public function render()
    {
        return view('livewire.translate-page')->layout('layouts.app', [
            'containContent' => $this->isMine,
        ]);
    }

    public function toggleClaimModal()
    {
        $this->isConfirmingClaim = !$this->isConfirmingClaim;
    }

    public function toggleUnclaimModal()
    {
        $this->isConfirmingUnclaim = !$this->isConfirmingUnclaim;
    }

    public function toggleSubmissionModal()
    {
        $this->isConfirmingSubmission = !$this->isConfirmingSubmission;
    }

    public function claimTranslationRequest()
    {
        $this->authorize('claim', $this->translationRequest);

        $this->translationRequest->assignTo(Auth::user());

        return redirect()->route('translate', [
            $this->translationRequest->id,
            $this->translationRequest->source->slug
        ]);
    }

    public function unclaimTranslationRequest()
    {
        $this->authorize('view', $this->translationRequest);

        $this->translationRequest->unclaim();

        return redirect()->route('translate', [
            $this->translationRequest->id,
            $this->translationRequest->source->slug
        ]);
    }

    public function saveTranslation(string $content, string $plainText)
    {
        $this->authorize('view', $this->translationRequest);

        $this->translationContent = $content;
        $this->translationPlainText = $plainText;

        $this->translationRequest->update([
            'content' => $this->translationContent,
            'plain_text' => $this->translationPlainText,
        ]);

        $this->dispatchBrowserEvent('toast-translation-request-saved');
    }

    public function submitTranslation()
    {
        $this->authorize('view', $this->translationRequest);

        $this->validate();

        $this->translationRequest->update([
            'content' => $this->translationContent,
            'plain_text' => $this->translationPlainText,
            'status' => TranslationRequestStatus::COMPLETE,
        ]);

        session()->flash('flash.banner', __('Your translation has been submitted. Thank you for your contribution!'));

        return redirect()->route('home');
    }

    protected function rules()
    {
        return [
            'translationContent' => ['required', 'string'],
            'translationPlainText' => ['required', 'string'],
        ];
    }
}
