<?php
Route::get('/projects', 'ProjectController@index')->name('project.index');
Route::post('/projects', 'ProjectController@store')->name('project.store');
Route::post('/projects/delete', 'ProjectController@destroy')->name('project.destroy');
Route::post('/projects/go', 'ProjectController@go')->name('project.go');
