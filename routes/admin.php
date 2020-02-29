<?php

// il nome rotta era users.index | App\Http\Controllers\Admin\AdminUsersController@index

Route::resource('users', 'Admin\AdminUsersController',
[
    'names' => [

        'index' => 'users.list'
    ]
]

);

Route::get('getUsers', 'Admin\AdminUsersController@getUsers')->name('get.users');

Route::patch('restore/{id}', 'Admin\AdminUsersController@restore')->name('users.restore');

// poi sarà users.list