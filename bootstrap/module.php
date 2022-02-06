<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Relations\Relation;

return function () {
    // Bind route models and constrains
    Route::pattern('tag', '[a-zA-Z0-9-_]+');
    Route::model('tag', config('rinvex.tags.models.tag'));

    // Map relations
    Relation::morphMap([
        'tag' => config('rinvex.tags.models.tag'),
    ]);
};
