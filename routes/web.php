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

Route::get('/', function () {
    return redirect(route('login'));
});

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    
    Route::group(['middleware' => ['role:admin']], function() {

        Route::resource('/role', 'RoleController')->except([
            'create', 'show', 'edit', 'update'
            ]);
            
            Route::resource('/users', 'UserController')->except([
                'show'
                ]);
            Route::get('/users/roles/{id}', 'UserController@roles')->name('users.roles');
            Route::post('/users/permission', 'UserController@addPermission')->name('users.add_permission');
            Route::get('/users/role-permission', 'UserController@rolePermission')->name('users.role_permission');
            Route::put('/users/permission/{role}', 'UserController@setRolePermission')->name('users.setRolePermission');
    });

    Route::group(['middleware' => ['role:kasir']], function() {
        Route::get('/transaction', 'OrderController@addOrder')->name('order.transaction');
        Route::get('/checkout', 'OrderController@checkout')->name('order.checkout');
        Route::post('/checkout', 'OrderController@storeOrder')->name('order.storeOrder');
    });

    Route::group(['middleware' => ['role:admin,kasir']], function() {
        Route::get('/order', 'OrderController@index')->name('order.index');
        Route::get('/order/pdf/{invoice}', 'OrderController@invoicePdf')->name('order.pdf');
        Route::post('/order/excel/{invoice}', 'OrderController@invoiceExcel')->name('order.excel');
    });
            
    Route::group(['middleware' => ['permission:show products|create products|delete products']], function() {
        
        Route::resource('/category', 'CategoryController')->except([
            'create', 'show'
        ]);
        Route::resource('/product', 'ProductController');
    });


        Route::get('/home', 'HomeController@index')->name('home');
});
