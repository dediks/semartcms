<?php

Route::get('/doc', 'DocController@index');

Route::group(['middleware' => 'auth'], function () {
    require base_path('routes/system/project.php');

    Route::middleware(['has_project'])->group(function () {
        require base_path('routes/system/dashboard.php');
        require base_path('routes/system/extension.php');

        Route::prefix('content-model')->name('content_model.')->group(function () {
            Route::get('/builder', 'ContentModelController@builder');
            Route::match(['post', 'get'], '/create', 'ContentModelController@layout')->name('layout');
            Route::post('generate', 'ContentModelController@generate')->name('generate');
            Route::delete('{table_name}/destroy', 'ContentModelController@destroy')->name('destroy');

            Route::get('', 'ContentModelController@index')->name('index');
            Route::get('/{cm?}', 'ContentModelController@index')->name('index');
            Route::get('/{cm?}/save', 'ContentModelController@save')->name('save');
            Route::get('/{cm?}/json', 'ContentModelController@getAttributes')->name('json');
            Route::post('/{cm?}/json/update', 'ContentModelController@updateJson')->name('update.json');
            Route::get('/edit/{cm}', 'ContentModelController@edit')->name('edit');
            Route::post('/update/{cm}', 'ContentModelController@update')->name('update');
            Route::post('/{cm}/delete-field', 'ContentModelController@deleteField')->name('delete-field');

            Route::post('/load', 'ContentModelController@load')->name('load');
            Route::post('/load-data', 'ContentModelController@loadRelatedModel')->name('load-related-model');
            Route::post('/load-related-data', 'ContentModelController@loadRelatedModelData')->name('load_related_model_data');
            Route::post('/submit', 'ContentModelController@submitRelatedModel')->name('submit-related-model');
            Route::post('/cek-name', 'ContentModelController@cekName')->name('cek_name');
        });

        Route::prefix('content-model-data')->name('content_model.data.')->group(function () {
            Route::post('/batch-destroy', 'ContentModelDataController@batchDestroy')->name('batch_destroy');
        });

        require base_path('routes/system/user.php');
        require base_path('routes/system/role.php');
        require base_path('routes/system/permission.php');
        require base_path('routes/system/setting.php');
        require base_path('routes/system/invite.php');

        // route for content model generator system
        require base_path('routes/system/content_model_generator.php');

        // route for generated models
        require base_path('routes/cm/cm_route.php');
    });




    Route::get('logout', function () {
        Auth::logout();
        request()->session()->forget('project');
        return redirect('/login')->withInfo('You have successfully logged out!');
    })->name('logout');
});


// Route::get('resendverification', 'UserController@resendVerification')->name('resendverification');
Auth::routes(['verify' => true, 'register' => true]);
