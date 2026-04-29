<?php

use App\Http\Controllers\CollectionController;
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