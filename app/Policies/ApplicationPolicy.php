<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Application;

class ApplicationPolicy
{
    public function view(User $user, Application $application): bool
    {
        return $user->id === $application->user_id;
    }

    public function delete(User $user, Application $application): bool
    {
        return $user->id === $application->user_id;
    }

    public function updateStatus(User $user, Application $application): bool
    {
        return $user->is_recruiter && $user->id === $application->jobOffer?->user_id;
    }
}
