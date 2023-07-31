<?php

namespace App\Http\Controllers;

use App\Models\Gastos;
use App\Models\TipoGasto;
use App\Models\DescripcionGasto;
use App\Models\RelacionGasto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
$mesesEnEspanol = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
class GastosController extends Controller
{
    const MESES_EN_ESPANOL = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
  /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $populares = TipoGasto::select('tipo_gastos.id', 'tipo_gastos.descripcion', DB::raw('COUNT(*) as total'))
            ->join('gastos', 'tipo_gastos.id', '=', 'gastos.tipo_gasto_id')
            ->where('gastos.idusuario', '=', Auth::id()) // Agregar cláusula where
            ->groupBy('tipo_gastos.id', 'tipo_gastos.descripcion')
            ->orderByDesc('total')
            ->limit(6)
            ->get();
    
        return view('gastos.index', compact('populares'));
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
        $request->validate([
            'tipoGasto' => 'required|string',
            'descripcion' => 'required|string',
            'monto_gasto' => 'required|numeric',
        ]);
        
        // Buscar o crear el tipo de gasto
        // $tipoGasto = TipoGasto::firstOrCreate(['descripcion' => $request->input('tipoGasto')]);
        $tipoGastoExistente = TipoGasto::where('descripcion', $request->input('tipoGasto'))
                                ->where('idusuario', Auth::id())
                                ->first();

        if (!$tipoGastoExistente) {
            $tipoGasto = new TipoGasto;
            $tipoGasto->idusuario = Auth::id();
            $tipoGasto->descripcion = $request->input('tipoGasto');
            $tipoGasto->save();
        } else {
            $tipoGasto = $tipoGastoExistente;
        }
        

    
        // Insertar el gasto
        $gasto = new Gastos;
        $gasto->tipo_gasto_id = $tipoGasto->id;
        $gasto->monto_gasto = $request->input('monto_gasto');
        $gasto->idusuario = Auth::id(); // Agregar el ID del usuario
        $gasto->save();
    
        // Insertar las descripciones
        $frases = explode(',', $request->input('descripcion'));
        // Filtrar los elementos vacíos o que no contienen letras
        $frases = preg_grep('/\S/', $frases);
        foreach ($frases as $frase) {
            $descripcion = DescripcionGasto::where('descripcion', trim($frase))
                        ->where('idusuario', Auth::id())
                        ->first();
            if (!$descripcion) {
                $descripcion = new DescripcionGasto;
                $descripcion->descripcion = trim($frase);
                $descripcion->tipo_gasto_id = $tipoGasto->id;
                $descripcion->idusuario = Auth::id(); // Agregar el ID del usuario
                $descripcion->save();
            }

            // Crear la relación entre gasto y descripción
            $gastoDescripcion = new RelacionGasto;
            $gastoDescripcion->gasto_id = $gasto->id;
            $gastoDescripcion->descripcion_gasto_id = $descripcion->id;
            $gastoDescripcion->save();
        }
    
        // Actualizar las descripciones con el ID del tipo de gasto
        DescripcionGasto::where('tipo_gasto_id', '=', 0)
            ->update(['tipo_gasto_id' => $tipoGasto->id]);
    
        return redirect()->route('gastos.index');
    }
    
      /**
     * Display the specified resource.
     */
    public function show(Request $request, Gastos $gastos)
    {
        // dd($request);
        $mesAnno = $request->input('mesAnno');
        $orderBy = $request->input('orderBy', 'id');
        $orderDir = $request->input('orderDir','asc');
    
        if (empty($mesAnno)) {
            $mes = date('m');
            $anno = date('Y');
        } else {
            $partes = explode('-', $mesAnno);
            $mes = $partes[0];
            $anno = $partes[1];
        }
    
        $idusuario = Auth::id();
        $query = Gastos::with('tipoGasto')
                        ->where('idusuario', $idusuario)
                        ->whereMonth('created_at', $mes)
                        ->whereYear('created_at', $anno);
    
        if (!empty($orderBy) && !empty($orderDir)) {
            $query = $query->orderBy($orderBy, $orderDir);
        }
    
        $gastos = $query->get();
        $suma = Gastos::where('idusuario', $idusuario)
                        ->whereMonth('created_at', $mes)
                        ->whereYear('created_at', $anno)
                        ->sum('monto_gasto');
        
        $fecha = self::MESES_EN_ESPANOL[$mes-1].', '.$anno;
    
        $opcionesMeses = $this->obtenerMesesConGastos(); 
        
        return view('gastos.estadisticas', [
            'gastos' => $gastos,
            'suma' => $suma,
            'fecha' => $fecha,
            'opcionesMeses' => $opcionesMeses,
            'orderBy' => $orderBy,
            'orderDir' => $orderDir
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $gastos = Gastos::select('gastos.id', 'gastos.monto_gasto', 'tipo_gastos.id as tipo_gasto_id','tipo_gastos.descripcion as tipo_gasto', DB::raw('GROUP_CONCAT(descripcion_gastos.descripcion SEPARATOR ", ") as descripcion_gasto'))
        ->join('tipo_gastos', 'gastos.tipo_gasto_id', '=', 'tipo_gastos.id')
        ->join('descripcion_gasto_gasto', 'descripcion_gasto_gasto.gasto_id', '=', 'gastos.id')
        ->join('descripcion_gastos', 'descripcion_gastos.id', '=', 'descripcion_gasto_gasto.descripcion_gasto_id')
        ->where('gastos.id', '=', $id)
        ->where('gastos.idusuario', '=', Auth::id()) 
        ->groupBy('gastos.id', 'gastos.monto_gasto','tipo_gastos.id','tipo_gastos.descripcion')
        ->firstOrFail();


        return view('gastos.edit', compact('gastos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $datosGastos = request()->except(['_token', '_method']);
    
        // Actualizar la tabla "Gastos"
        Gastos::where('id','=',$id)->update([
            'monto_gasto' => $datosGastos['monto_gasto']
        ]);
    
        // Obtener las palabras de la descripción de gasto
        $palabras = explode(',', $datosGastos['descripcion']);
    
        // Eliminar todos los registros correspondientes al gasto_id en la tabla "RelacionGasto"
        RelacionGasto::where('gasto_id', '=', $id)->delete();
    
        // Actualizar la tabla "RelacionGasto" para cada palabra de la descripción
        foreach ($palabras as $palabra) {
            $palabra = trim($palabra);
    
            // Obtener el id de la descripción de gasto correspondiente
            $descripcion = DescripcionGasto::where('descripcion', '=', $palabra)->first();
            $descripcionId = $descripcion->id;
    
            // Actualizar la tabla "RelacionGasto"
            RelacionGasto::create([
                'gasto_id' => $id,
                'descripcion_gasto_id' => $descripcionId
            ]);
        }
    
        // Redireccionar a la página de estadísticas de gastos
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


    public function autocomplete(Request $request)
    {
        $query = $request->get('term', '');
        $tabla = $request->get('tabla', '');
        $tipoGastoId = $request->get('tipoGastoId', '');
        
        $validator = Validator::make(['query' => $query], [
            'query' => 'required|regex:/^[a-zA-Z0-9\s,]+$/',
        ]);
        
        
        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input']);
        }
        
        if ($tabla === 'DescripcionGasto') {
            $resultados = DescripcionGasto::where('descripcion', 'LIKE', '%'.$query.'%')
                ->where('tipo_gasto_id', $tipoGastoId)
                ->get();
        } else {
            $resultados = TipoGasto::where('descripcion', 'LIKE', '%'.$query.'%')->get();
        }
        
        $data = [];
        foreach ($resultados as $resultado) {
            $data[] = [
                'value' => $resultado->descripcion,
                'id' => $resultado->id,
            ];
        }
        
        return response()->json($data);
    }
    
    

    public function getDescripciones($tipo_gasto_id)
    {
        $descripciones = DB::table('descripcion_gasto_gasto')
            ->join('descripcion_gastos', 'descripcion_gastos.id', '=', 'descripcion_gasto_gasto.descripcion_gasto_id')
            ->join('tipo_gastos', 'tipo_gastos.id', '=', 'descripcion_gastos.tipo_gasto_id')
            ->select('descripcion_gastos.descripcion', DB::raw('COUNT(*) AS contador'))
            ->where('tipo_gastos.id', $tipo_gasto_id)
            ->where('tipo_gastos.idusuario', Auth::id())
            ->groupBy('descripcion_gastos.descripcion', 'descripcion_gasto_gasto.descripcion_gasto_id')
            ->orderBy('contador', 'desc')
            ->limit(10)
            ->pluck('descripcion_gastos.descripcion')
            ->toArray();
    
        return response()->json([$descripciones]);
    }
    
    

    public function getDescripcionesEstadisticas($gasto_id)
    {
        
        $descripciones = RelacionGasto::join('descripcion_gastos', 'descripcion_gastos.id', '=', 'descripcion_gasto_gasto.descripcion_gasto_id')
        ->where('descripcion_gasto_gasto.gasto_id', $gasto_id)
        ->select('descripcion_gastos.descripcion')
        ->pluck('descripcion_gastos.descripcion')
        ->toArray();

        return response()->json([$descripciones]);
    }

    public function obtenerMesesConGastos()
    {
        $mesesConGastos = Gastos::selectRaw('MONTH(updated_at) as mes, YEAR(updated_at) as anno')
            ->groupBy('mes', 'anno')
            ->get();
    
        $opcionesMeses = [];
        foreach ($mesesConGastos as $mesGasto) {
            $nombreMes = self::MESES_EN_ESPANOL[$mesGasto->mes - 1]; // Obtener el nombre del mes en español
            $fecha = $mesGasto->mes . '-' . $mesGasto->anno; // Formato 'm-Y'
            $opcion = $nombreMes . ', ' . $mesGasto->anno;
            $opcionesMeses[$fecha] = $opcion;
        }
    
        return $opcionesMeses;  
    }

    public function sumaGastosDetalle(Request $request){
        $idGasto = $request->input('idGasto');
        $idFecha = $request->input('idFecha');
        $partes = explode('-', $idFecha);
        $mes = $partes[0];
        $anno = $partes[1];
        
        $suma = Gastos::join('tipo_gastos', 'tipo_gastos.id', '=', 'gastos.tipo_gasto_id')
            ->where('tipo_gastos.id', $idGasto)
            ->whereMonth('gastos.updated_at', $mes)
            ->whereYear('gastos.updated_at', $anno)
            ->select('tipo_gastos.descripcion')
            ->sum('gastos.monto_gasto');
            
            $descripcion = TipoGasto::where('id', $idGasto)->value('descripcion');

            return response()->json([
                'suma' => $suma,
                'descripcion' => $descripcion,
            ]);
    }
    
    
}