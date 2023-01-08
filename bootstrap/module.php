<?php

declare(strict_types=1);

return function () {
    // Bind route models and constrains
    Route::pattern('tag', '[a-zA-Z0-9-_]+');
    Route::model('tag', config('rinvex.tags.models.tag'));
};
