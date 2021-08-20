<?php

namespace App\Policies;

use App\Http\Livewire\TranslationPage;
use App\Models\Source;
use App\Models\TranslationRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SourcePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Source $source)
    {
        return $source->author_id === $user->id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Source $source)
    {
        return $source->author_id === $user->id;
    }

    public function delete(User $user, Source $source)
    {
        return $source->author_id === $user->id;
    }
}
