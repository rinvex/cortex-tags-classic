<?php

declare(strict_types=1);

Route::group(['domain' => domain()], function () {

    Route::name('adminarea.')
         ->namespace('Cortex\Taggable\Http\Controllers\Adminarea')
         ->middleware(['web', 'nohttpcache', 'can:access-dashboard'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/adminarea' : 'adminarea')->group(function () {

        // Tags Routes
        Route::name('tags.')->prefix('tags')->group(function () {
            Route::get('/')->name('index')->uses('TagsController@index');
            Route::get('create')->name('create')->uses('TagsController@form');
            Route::post('create')->name('store')->uses('TagsController@store');
            Route::get('{tag}')->name('edit')->uses('TagsController@form');
            Route::put('{tag}')->name('update')->uses('TagsController@update');
            Route::get('{tag}/logs')->name('logs')->uses('TagsController@logs');
            Route::delete('{tag}')->name('delete')->uses('TagsController@delete');
        });

    });

});
