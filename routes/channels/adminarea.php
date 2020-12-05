<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Access\Authorizable;

Broadcast::channel('adminarea-tags-index', function (Authorizable $user) {
    return $user->can('list', app('rinvex.tags.tag'));
}, ['guards' => ['admin']]);
