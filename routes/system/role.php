<?php

Route::prefix('roles')->name('roles.')->group(function () {
  Route::get('/', 'RoleController@index')->name('index');
  Route::get('create', 'RoleController@create')->name('create');
  Route::post('/', 'RoleController@store')->name('store');
  Route::get('{id}/edit', 'RoleController@edit')->name('edit');
  Route::patch('{id}', 'RoleController@update')->name('update');
  Route::put('{id}', 'RoleController@update')->name('update');
  Route::delete('{id}/delete', 'RoleController@destroy')->name('destroy');
});
