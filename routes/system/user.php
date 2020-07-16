<?php

Route::prefix('users')->name('users.')->group(function () {
  Route::get('/', 'UserController@index')->name('index');
  Route::get('/data', 'UserController@data')->name('data');
  Route::get('create', 'UserController@create')->name('create');
  Route::post('/', 'UserController@store')->name('store');
  Route::get('{id}/edit', 'UserController@edit')->name('edit');
  Route::patch('{id}', 'UserController@update')->name('update');
  Route::put('{id}', 'UserController@update')->name('update');
  Route::delete('{id}/delete', 'UserController@destroy')->name('destroy');
});
