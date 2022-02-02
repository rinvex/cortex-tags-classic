<?php

declare(strict_types=1);

use Cortex\Tags\Http\Controllers\Adminarea\TagsController;

Route::domain('{adminarea}')->group(function () {
    Route::name('adminarea.')
         ->middleware(['web', 'nohttpcache', 'can:access-adminarea'])
         ->prefix(route_prefix('adminarea'))->group(function () {

        // Tags Routes
             Route::name('cortex.tags.tags.')->prefix('tags')->group(function () {
                 Route::match(['get', 'post'], '/')->name('index')->uses([TagsController::class, 'index']);
                 Route::get('import')->name('import')->uses([TagsController::class, 'import']);
                 Route::post('import')->name('stash')->uses([TagsController::class, 'stash']);
                 Route::post('hoard')->name('hoard')->uses([TagsController::class, 'hoard']);
                 Route::get('import/logs')->name('import.logs')->uses([TagsController::class, 'importLogs']);
                 Route::get('create')->name('create')->uses([TagsController::class, 'create']);
                 Route::post('create')->name('store')->uses([TagsController::class, 'store']);
                 Route::get('{tag}')->name('show')->uses([TagsController::class, 'show']);
                 Route::get('{tag}/edit')->name('edit')->uses([TagsController::class, 'edit']);
                 Route::put('{tag}/edit')->name('update')->uses([TagsController::class, 'update']);
                 Route::match(['get', 'post'], '{tag}/logs')->name('logs')->uses([TagsController::class, 'logs']);
                 Route::delete('{tag}')->name('destroy')->uses([TagsController::class, 'destroy']);
             });
         });
});
