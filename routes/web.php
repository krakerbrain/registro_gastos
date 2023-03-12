<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GastosController;

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
Route::redirect('/', '/gastos');

// Route::get('/', function () {
//     return view('gastos');
// });
// Route::get('/gastos', function () {
//     return view('gastos.index');
// });

Route::resource('gastos', GastosController::class);
Route::get('autocomplete', [GastosController::class, 'autocomplete'])->name('autocomplete');
