<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return true; // Any authenticated user can create a review
    }

    public function update(User $user, Review $review)
    {
        return $user->id === $review->user_id || $user->isAdmin();
    }

    public function delete(User $user, Review $review)
    {
        return $user->id === $review->user_id || $user->isAdmin();
    }

    public function moderate(User $user)
    {
        return $user->isAdmin();
    }
} 