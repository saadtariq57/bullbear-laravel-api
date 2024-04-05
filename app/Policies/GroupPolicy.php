<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GroupPolicy
{

    public function view(User $user, Group $group)
    {
        // Check if the user is an active member of the group
        return $group->groupMembers()
                     ->where('user_id', $user->id)
                     ->where('active', '1')
                     ->exists();
    }

    // Determine if the user can manage the group (for admins)
    public function manage(User $user, Group $group)
    {
        return $group->groupMembers()
                     ->where('user_id', $user->id)
                     ->where('role', 'admin')
                     ->where('active', '1')
                     ->exists();
    }
}
