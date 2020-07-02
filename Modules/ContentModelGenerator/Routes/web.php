<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'has_project'])->group(function () {
    Route::prefix('contentmodelgenerator')->group(function () {
        Route::get('/', 'ContentModelGeneratorController@index')->name('cm.index');;
        Route::get('/create', 'ContentModelGeneratorController@create')->name('cm.create');
    });
});
