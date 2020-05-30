<?php

declare(strict_types=1);

Broadcast::channel('adminarea-tags-index', function ($user) {
    return $user->can('list', app('rinvex.tags.tag'));
}, ['guards' => ['admin']]);
