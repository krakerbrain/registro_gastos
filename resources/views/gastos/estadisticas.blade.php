@include('partials.header')
                <div class="d-flex justify-content-between">
                    <h4>Total de gastos </h4>
                    <h4>$ {{$suma}}</h4>
                </div>
                <table class="table table-striped table-bordered small">
                    <thead>
                        <tr>
                            <th class="text-center">Descripción</th>
                            <th class="text-center">Monto Gasto</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gastos as $gasto)
                            <tr>
                                <td class="align-baseline">{{ $gasto->descripcion }}</td>
                                <td class="align-baseline text-center">$ {{ $gasto->monto_gasto }}</td>
                                <td class="align-baseline text-center">{{ date_format($gasto->created_at, "d/m/Y") }}</td>
                                <td class="d-flex align-items-center justify-content-around">
                                    <a href="{{url('/gastos/'.$gasto->id.'/edit')}}" title="Editar"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form action="{{ url('/gastos/'. $gasto->id) }}" method="post" id="editaGasto">
                                        @csrf
                                        {{method_field('DELETE')}}
                                        <button class="btn bg-transparent" onclick="return confirm('Esta seguro de borrar el registro?')" title="Eliminar">
                                            <i class="fa-regular fa-trash-can text-primary"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>