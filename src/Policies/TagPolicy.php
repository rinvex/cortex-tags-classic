<?php

declare(strict_types=1);

namespace Cortex\Taggable\Policies;

use Cortex\Fort\Models\User;
use Cortex\Taggable\Models\Tag;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list tags.
     *
     * @param string                   $ability
     * @param \Cortex\Fort\Models\User $user
     *
     * @return bool
     */
    public function list($ability, User $user)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can create tags.
     *
     * @param string                   $ability
     * @param \Cortex\Fort\Models\User $user
     *
     * @return bool
     */
    public function create($ability, User $user)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can update the tag.
     *
     * @param string                                $ability
     * @param \Cortex\Fort\Models\User              $user
     * @param \Cortex\Taggable\Models\Tag $resource
     *
     * @return bool
     */
    public function update($ability, User $user, Tag $resource)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can update tags
    }

    /**
     * Determine whether the user can delete the tag.
     *
     * @param string                                $ability
     * @param \Cortex\Fort\Models\User              $user
     * @param \Cortex\Taggable\Models\Tag $resource
     *
     * @return bool
     */
    public function delete($ability, User $user, Tag $resource)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can delete tags
    }
}
