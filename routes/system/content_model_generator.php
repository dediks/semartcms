<?php

// Route::get('/builder')->name('content_model_generator.builder');
Route::get('fields/{type}/{file}', 'ContentModelGeneratorController@loadFields')->name('fields.file');
