<?php

declare(strict_types=1);

namespace Cortex\Taggable\Policies;

use Rinvex\Fort\Contracts\UserContract;
use Rinvex\Taggable\Contracts\TagContract;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list tags.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Contracts\UserContract $user
     *
     * @return bool
     */
    public function list($ability, UserContract $user)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can create tags.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Contracts\UserContract $user
     *
     * @return bool
     */
    public function create($ability, UserContract $user)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can update the tag.
     *
     * @param string                                 $ability
     * @param \Rinvex\Fort\Contracts\UserContract    $user
     * @param \Rinvex\Taggable\Contracts\TagContract $resource
     *
     * @return bool
     */
    public function update($ability, UserContract $user, TagContract $resource)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can update tags
    }

    /**
     * Determine whether the user can delete the tag.
     *
     * @param string                                 $ability
     * @param \Rinvex\Fort\Contracts\UserContract    $user
     * @param \Rinvex\Taggable\Contracts\TagContract $resource
     *
     * @return bool
     */
    public function delete($ability, UserContract $user, TagContract $resource)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can delete tags
    }
}
