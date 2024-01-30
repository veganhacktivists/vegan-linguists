<?php

namespace App\Http\Livewire;

use App\Models\TranslationRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class TranslatePage extends Component
{
    use AuthorizesRequests;

    public TranslationRequest $translationRequest;
    public string $translationContent;
    public string $translationPlainText;
    public bool $isConfirmingClaim = false;
    public bool $isConfirmingUnclaim = false;
    public bool $isConfirmingApproval = false;
    public bool $isConfirmingSubmission = false;
    public bool $isConfirmingReview = false;
    public bool $isMine;
    public bool $canReview;

    protected $listeners = [
        'toggleClaimModal',
        'toggleSubmissionModal',
        'toggleApprovalModal',
        'toggleUnclaimModal',
        'toggleStartReviewingModal',
    ];

    public function mount(
        TranslationRequest $translationRequest,
        string $slug = ''
    ) {
        $this->authorize('view', $translationRequest);
        $this->isMine = $translationRequest->isClaimedBy(Auth::user());
        $this->canReview = Gate::allows('review', $translationRequest);

        if ($slug !== $translationRequest->source->slug) {
            return redirect()->route('translate', [
                $translationRequest->id,
                $translationRequest->source->slug,
            ]);
        }

        $this->translationRequest = $translationRequest;
        $this->translationContent = $translationRequest->content;
        $this->translationPlainText = $translationRequest->plain_text;

        if (session('status') === 'verification-link-sent') {
            session()->flash(
                'flash.banner',
                __(
                    'An email has been sent to you with a link to verify your email address!'
                )
            );
        }
    }

    public function render()
    {
        return view('livewire.translate-page')->extends('layouts.app', [
            'containContent' => $this->isMine || $this->canReview,
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
        $this->resetErrorBag();
    }

    public function toggleApprovalModal()
    {
        $this->isConfirmingApproval = !$this->isConfirmingApproval;
    }

    public function toggleStartReviewingModal()
    {
        $this->isConfirmingReview = !$this->isConfirmingReview;
    }

    public function claimTranslationRequest()
    {
        $this->authorize('claim', $this->translationRequest);

        $this->translationRequest->assignTo(Auth::user());

        return redirect()->route('translate', [
            $this->translationRequest->id,
            $this->translationRequest->source->slug,
        ]);
    }

    public function unclaimTranslationRequest()
    {
        if (!$this->translationRequest->isClaimed()) {
            return;
        }

        $this->authorize('view', $this->translationRequest);

        $this->translationRequest->unclaim();

        return redirect()->route('translate', [
            $this->translationRequest->id,
            $this->translationRequest->source->slug,
        ]);
    }

    public function startReviewing()
    {
        $this->authorize('claimForReview', $this->translationRequest);

        $this->translationRequest->addReviewer(Auth::user());

        return redirect()->route('translate', [
            $this->translationRequest->id,
            $this->translationRequest->source->slug,
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
        if (!$this->translationRequest->isClaimed()) {
            return;
        }

        $this->authorize('view', $this->translationRequest);

        $this->validate();

        $this->translationRequest->submit(
            $this->translationContent,
            $this->translationPlainText
        );

        $successMessage = $this->translationRequest->isUnderReview()
            ? __(
                'Your translation has been submitted to be reviewed by others. Thank you!'
            )
            : __(
                'Your translation has been submitted. Thank you for your contribution!'
            );

        session()->flash('flash.banner', $successMessage);

        return redirect()->route('home');
    }

    public function startReviewComment(array $selection)
    {
        $this->authorize('review', $this->translationRequest);

        $this->dispatchBrowserEvent('change-tab', 'discussion');
        $this->dispatchBrowserEvent('comment-quote', [
            'content' => json_decode($selection['content']),
            'metadata' => [
                'annotation' => [
                    'index' => $selection['index'],
                    'length' => $selection['length'],
                ],
                'resolved_at' => null,
            ],
        ]);
    }

    public function approveTranslation()
    {
        $this->authorize('approve', $this->translationRequest);

        $this->translationRequest->setApproval(Auth::user());

        session()->flash(
            'flash.banner',
            __(
                'The translation has been marked as approved by you. Thank you for your contribution!'
            )
        );

        return redirect()->route('home');
    }

    protected function rules()
    {
        return [
            'translationContent' => ['required', 'string'],
            'translationPlainText' => ['required', 'string'],
        ];
    }

    protected function messages()
    {
        return [
            'translationPlainText.required' => __(
                'You must enter content before submitting.'
            ),
        ];
    }
}
