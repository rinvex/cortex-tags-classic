<?php

declare(strict_types=1);

Route::group(['domain' => domain()], function () {

    Route::name('backend.')
         ->namespace('Cortex\Taggable\Http\Controllers\Backend')
         ->middleware(['web', 'nohttpcache', 'can:access-dashboard'])
         ->prefix(config('rinvex.cortex.route.locale_prefix') ? '{locale}/backend' : 'backend')->group(function () {

        // Tags Routes
        Route::name('tags.')->prefix('tags')->group(function () {
            Route::get('/')->name('index')->uses('TagsController@index');
            Route::get('create')->name('create')->uses('TagsController@form');
            Route::post('create')->name('store')->uses('TagsController@store');
            Route::get('{tag}')->name('edit')->uses('TagsController@form')->where('tag', '[0-9]+');
            Route::put('{tag}')->name('update')->uses('TagsController@update')->where('tag', '[0-9]+');
            Route::get('{tag}/logs')->name('logs')->uses('TagsController@logs')->where('tag', '[0-9]+');
            Route::delete('{tag}')->name('delete')->uses('TagsController@delete')->where('tag', '[0-9]+');
        });

    });

});
