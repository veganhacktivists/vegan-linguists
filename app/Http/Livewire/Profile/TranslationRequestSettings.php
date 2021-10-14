<?php

namespace App\Http\Livewire\Profile;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TranslationRequestSettings extends Component
{
    public array $targetLanguages;

    protected $rules = [
        'targetLanguages' => ['array', 'exists:languages,id'],
    ];

    public function mount()
    {
        $this->targetLanguages = Auth::user()->default_target_languages->toArray();
    }

    public function render()
    {
        return view('livewire.profile.translation-request-settings');
    }

    public function save()
    {
        $this->validate();

        Auth::user()->default_target_languages = $this->targetLanguages;

        $this->emit('saved');
    }
}
