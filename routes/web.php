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

Auth::routes();

Route::view('/home', 'dashboard')->name('dashboard')->middleware(['web', 'auth']);
Route::view('/', 'dashboard')->name('dashboard')->middleware(['web', 'auth']);

Route::group(['prefix' => 'users', 'as' => 'users.', 'middleware' => ['web', 'auth']], function (){
    Route::view('/', 'users.index')->name('list');
    Route::view('create', 'users.create')->name('create');
    Route::view('{user}', 'users.detail')->name('detail');
    Route::view('{user}/edit', 'users.edit')->name('edit');
});

Route::group(['prefix' => 'financial', 'as' => 'financial.', 'middleware' => ['web', 'auth']], function (){
    Route::view('incoming', 'financial.incoming')->name('incoming');
    Route::view('expenses', 'financial.expenses')->name('expenses');
    Route::view('accounts', 'financial.accounts.index')->name('accounts');
    Route::view('balance', 'financial.balance')->name('balance');
});
