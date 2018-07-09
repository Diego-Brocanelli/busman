<?php

use Busman\Utils\LanguageExport;

Route::get(config('busman.trans_route'), function ($lang) {
    return LanguageExport::all($lang);
})->middleware('auth:api');

Route::get(config('busman.route_list_route'), 'Busman\Utils\Http\Controllers\RouteListController@index')->middleware('web');
