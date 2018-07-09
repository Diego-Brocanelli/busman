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

Route::view('/', 'dashboard')->name('dashboard');

Route::group(['prefix' => 'users', 'as' => 'users.'], function (){
    Route::view('/', 'users.index')->name('list');
    Route::view('create', 'users.create')->name('create');
    Route::view('{user}', 'users.detail')->name('detail');
    Route::view('{user}/edit', 'users.edit')->name('edit');
});

Route::group(['prefix' => 'financial', 'as' => 'financial.'], function (){
    Route::view('incoming', 'financial.incoming')->name('incoming');
    Route::view('expenses', 'financial.expenses')->name('expenses');
    Route::view('accounts', 'financial.accounts')->name('accounts');
    Route::view('balance', 'financial.balance')->name('balance');
});
