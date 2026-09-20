<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Resume;

class ResumePolicy
{
    public function update(User $user, Resume $resume): bool
    {
        return $user->id === $resume->user_id;
    }

    public function delete(User $user, Resume $resume): bool
    {
        return $user->id === $resume->user_id;
    }
}
