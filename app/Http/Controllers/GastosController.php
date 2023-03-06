<?php

namespace App\Http\Controllers;

use App\Models\Gastos;
use Illuminate\Http\Request;

class GastosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('gastos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('gastos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // $datosGastos = request()->all();
        $datosGastos = request()->except('_token');
        Gastos::create($datosGastos);
        return redirect('gastos/estadisticas');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gastos $gastos)
    {
        //
        $gastos = Gastos::all();
        $suma = Gastos::sum('monto_gasto');
        return view('gastos.estadisticas', [
                                            'gastos' => $gastos,
                                             'suma' => $suma
                                            ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $gastos = Gastos::findOrFail($id);
        return view('gastos.edit', compact('gastos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $datosGastos = request()->except(['_token', '_method']);
        Gastos::where('id','=',$id)->update($datosGastos);
        return redirect('gastos/estadisticas');
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        Gastos::destroy($id);
        return redirect('gastos/estadisticas');

    }
}
