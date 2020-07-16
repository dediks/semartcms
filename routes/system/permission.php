<?php

Route::prefix('permissions')->name('permission.')->group(function () {
  Route::get('/', 'PermissionController@index')->name('index');
  Route::get('create', 'PermissionController@create')->name('create');
  Route::post('/', 'PermissionController@store')->name('store');
  Route::get('{id}/edit', 'PermissionController@edit')->name('edit');
  Route::patch('{id}', 'PermissionController@update')->name('update');
  Route::put('{id}', 'PermissionController@update')->name('update');
  Route::delete('{id}/delete', 'PermissionController@destroy')->name('destroy');
});
