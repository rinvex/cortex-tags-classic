<?php

declare(strict_types=1);

namespace Cortex\Tags\Policies;

use Rinvex\Tags\Models\Tag;
use Rinvex\Fort\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list tags.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Models\User $user
     *
     * @return bool
     */
    public function list($ability, User $user): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can create tags.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Models\User $user
     *
     * @return bool
     */
    public function create($ability, User $user): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can update the tag.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Models\User $user
     * @param \Rinvex\Tags\Models\Tag  $resource
     *
     * @return bool
     */
    public function update($ability, User $user, Tag $resource): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can update tags
    }

    /**
     * Determine whether the user can delete the tag.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Models\User $user
     * @param \Rinvex\Tags\Models\Tag  $resource
     *
     * @return bool
     */
    public function delete($ability, User $user, Tag $resource): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can delete tags
    }
}
