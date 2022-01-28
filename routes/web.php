<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/subscribe', function () {
    return view('subscribe',[
        'intent' => auth()->user()->createSetupIntent()
    ]);
})->name('subscribe');



Route::post('/subscribe', function () {
    auth()->user()->newSubscription(
        'default', request()->plan
    )->create(request()->paymentMethodId);
})->name('subscribe.post');


Route::get('/singlecharge', function () {
    return view('singlecharge',[
        'intent' => auth()->user()->createSetupIntent()
    ]);
})->name('singlecharge');



Route::post('/singlecharge', function () {
   $charge=auth()->user()->charge(100,request()->paymentMethodId);



})->name('singlecharge.post');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
