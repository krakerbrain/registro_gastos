<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GastosController;
use App\Http\Controllers\RegistroUsuario;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;

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
Route::redirect('/', '/login');

// Route::get('/gastos', function () {
//     return view('gastos.index');
// });
Route::group(['middleware' => 'auth'], function () {
    // Rutas protegidas por autenticación
    Route::resource('gastos', GastosController::class);
    Route::get('/logout', [LogoutController::class, 'logout']);
    // Otras rutas...
});
// Route::resource('gastos', GastosController::class);
Route::get('autocomplete', [GastosController::class, 'autocomplete'])->name('autocomplete');
// Route::get('autocompleteDesc', [GastosController::class, 'autocompleteDesc'])->name('autocompleteDesc');
Route::get('get_descripciones/{tipo_gasto_id}', [GastosController::class, 'getDescripciones'])->name('get_descripciones');
Route::get('get_descripciones_estadisticas/{gasto_id}', [GastosController::class, 'getDescripcionesEstadisticas'])->name('get_descripciones_estadisticas');
Route::get('obtenerMesesConGastos', [GastosController::class, 'obtenerMesesConGastos'])->name('obtenerMesesConGastos');
Route::get('/suma-gastos-detalle', [GastosController::class, 'sumaGastosDetalle']);


Route::get('/register', [RegistroUsuario::class, 'show']);
Route::post('/register', [RegistroUsuario::class, 'register']);

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);