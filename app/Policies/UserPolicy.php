<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function isAdmin(User $user)
    {
        return $user->type === 'admin';
    }
    public function isActive(User $user)
    {
        return $user->status === 'active';
    }
}
