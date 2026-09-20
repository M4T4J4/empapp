<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Favorite;

class FavoritePolicy
{
    public function delete(User $user, Favorite $favorite): bool
    {
        return $user->id === $favorite->user_id;
    }
}
