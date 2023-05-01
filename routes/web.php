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
Route::get('get_descripciones/{tipo_gasto_id}', [GastosController::class, 'getDescripciones'])->name('get_descripciones');
Route::get('get_descripciones_estadisticas/{gasto_id}', [GastosController::class, 'getDescripcionesEstadisticas'])->name('get_descripciones_estadisticas');





