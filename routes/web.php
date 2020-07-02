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
Route::get('/tess', 'ContentModelController@tes');

Route::get('/', function () {
    // return view('home');
    return redirect('/dashboard');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/projects', 'ProjectController@index')->name('project.index');
    Route::post('/projects', 'ProjectController@store')->name('project.store');

    Route::post('/dashboard', 'DashboardController@go')->name('dashboard.go');
    Route::get('/extension', 'ExtensionController@index')->name('extension.index');

    Route::middleware(['has_project'])->group(function () {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');

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
        });
    });

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

    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', 'RoleController@index')->name('index');
        Route::get('create', 'RoleController@create')->name('create');
        Route::post('/', 'RoleController@store')->name('store');
        Route::get('{id}/edit', 'RoleController@edit')->name('edit');
        Route::patch('{id}', 'RoleController@update')->name('update');
        Route::put('{id}', 'RoleController@update')->name('update');
        Route::delete('{id}/delete', 'RoleController@destroy')->name('destroy');
    });

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('list', 'SettingController@list')->name('list');
        Route::get('create', 'SettingController@create')->name('create');
        Route::post('create', 'SettingController@store')->name('store');
        Route::get('{id}/edit', 'SettingController@edit')->name('edit');
        Route::put('{id}', 'SettingController@update')->name('update');
        Route::patch('{id}', 'SettingController@update')->name('update');
        Route::delete('{id}/delete', 'SettingController@destroy')->name('destroy');
        Route::put('{setting?}/save', 'SettingController@save')->name('save');
        Route::patch('{setting?}/save', 'SettingController@save')->name('save');
        Route::get('{setting?}', 'SettingController@index')->name('index');
    });

    // Setting Items
    Route::prefix('setting_items')->name('setting_items.')->group(function () {
        Route::get('list', 'SettingItemController@list')->name('list');
        Route::get('create', 'SettingItemController@create')->name('create');
        Route::post('create', 'SettingItemController@store')->name('store');
        Route::get('{id}/edit', 'SettingItemController@edit')->name('edit');
        Route::put('{id}', 'SettingItemController@update')->name('update');
        Route::patch('{id}', 'SettingItemController@update')->name('update');
        Route::delete('{id}/delete', 'SettingItemController@destroy')->name('destroy');
    });

    Route::group(['prefix' => 'fields'], function () {
        Route::get('{type}/{file}', function ($type, $file) {
            $path = resource_path("stuff/files/" . $file . "." . $type);

            if (file_exists($path)) {
                $content = file_get_contents($path);
                if ($type == 'json') {
                    $content = json_decode($content);
                }

                return response(['data' => $content], 200);
            }
            return response(['data' => "File can't be found (" . $path . ")"], 404);
        })->name('fields.file');
    });

    include(base_path('routes/cm/cm_route.php'));
});

Route::middleware('auth')->get('logout', function () {
    Auth::logout();
    return redirect('/login')->withInfo('You have successfully logged out!');
})->name('logout');

Route::get('resendverification', 'UserController@resendVerification')->name('resendverification');
Auth::routes(['verify' => true, 'register' => 'false']);
