<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProductController as ControllersProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * Auth route
 */
require __DIR__ . '/auth.php';

Route::get('/', ControllersProductController::class)->name('products.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group([
    'middleware' => ['auth'],
    'as' => 'admin.',
    'prefix' => 'admin'
], function () {
    Route::resource('products', ProductController::class);
});
