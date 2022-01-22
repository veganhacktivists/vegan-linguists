<?php

namespace App\Policies;

use App\Models\Source;
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
        return $source->isOwnedBy($user);
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Source $source)
    {
        return $source->isOwnedBy($user);
    }

    public function delete(User $user, Source $source)
    {
        return $source->isOwnedBy($user);
    }
}
