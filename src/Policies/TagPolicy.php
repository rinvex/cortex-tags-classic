<?php

declare(strict_types=1);

namespace Cortex\Tags\Policies;

use Rinvex\Tags\Contracts\TagContract;
use Rinvex\Fort\Contracts\UserContract;
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
    public function list($ability, UserContract $user): bool
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
    public function create($ability, UserContract $user): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can update the tag.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Contracts\UserContract $user
     * @param \Rinvex\Tags\Contracts\TagContract  $resource
     *
     * @return bool
     */
    public function update($ability, UserContract $user, TagContract $resource): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can update tags
    }

    /**
     * Determine whether the user can delete the tag.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Contracts\UserContract $user
     * @param \Rinvex\Tags\Contracts\TagContract  $resource
     *
     * @return bool
     */
    public function delete($ability, UserContract $user, TagContract $resource): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can delete tags
    }
}
