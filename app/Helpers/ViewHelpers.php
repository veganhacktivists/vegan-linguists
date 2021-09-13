<?php

// Loaded in composer.json

use App\Models\User;

function user(User|null $user)
{
    if (!$user) return User::deletedUser();

    return $user;
}
