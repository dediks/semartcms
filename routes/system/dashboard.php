<?php

Route::get('/', function () {
  return redirect('/dashboard');
});

Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
