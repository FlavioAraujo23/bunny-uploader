<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('collections', CollectionController::class)->only([
    'index',
    'create',
    'store'
]);

Route::post('/collections/{collection}', [CollectionController::class, 'select'])->name('collections.select');

Route::resource('videos', VideoController::class)->only([
    'index',
    'store',
    'update'
]);