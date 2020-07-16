<?php

Route::prefix('settings')->name('settings.')->group(function () {
  Route::get('', 'SettingController@index')->name('index');
});
