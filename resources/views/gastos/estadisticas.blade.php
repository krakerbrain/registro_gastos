@php
    use Magarrent\LaravelCurrencyFormatter\Facades\Currency;
@endphp
@include('partials.header')
@auth
                <div class="d-flex justify-content-between">

                    <form action="{{ route('obtenerMesesConGastos') }}" method="GET" id="formMeses">
                        @csrf
                        <select name="mesAnno" onchange="seleccionarOpcion(this.options[this.selectedIndex].id)">
                            @foreach (array_reverse($opcionesMeses) as $clave => $opcion)
                                <option id="{{ $clave }}" value="{{ $opcion }}" @if ($fecha == $opcion) selected @endif>{{ $opcion }}</option>
                            @endforeach
                        </select>
                    </form>
            
                    <h4>$ {{$suma}}</h4>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                                @php
                                function construirURL($orderBy, $orderDir, $currentOrderBy) {
                                    $orderDirParam = $orderBy === $currentOrderBy && $orderDir === 'asc' ? 'desc' : 'asc';
                                    $mesAnno = $_GET['mesAnno'] ?? '';
                                    $url = url('gastos/estadisticas?orderBy=' . $orderBy . '&orderDir=' . $orderDirParam . '&mesAnno=' . $mesAnno);
                                    return $url;
                                }
                                function obtenerIconoCaret($orderBy, $orderDir, $currentOrderBy) {
                                    if ($orderBy === $currentOrderBy) {
                                        if ($orderDir === 'asc') {
                                            return '<i class="fas fa-caret-up"></i>';
                                        } elseif ($orderDir === 'desc') {
                                            return '<i class="fas fa-caret-down"></i>';
                                        }
                                    }
                            
                                    return '';
                                }
                                @endphp
                            <th class="text-center">
                                <a href="{{ construirURL('tipo_gasto_id', $orderDir, $orderBy) }}" class="{{ $orderBy === 'tipo_gasto_id' ? 'active' : '' }}">
                                    Gasto
                                    {!! obtenerIconoCaret('tipo_gasto_id', $orderDir, $orderBy) !!}
                                </a>
                            </th>
                            <th class="text-center">
                                <a href="{{ construirURL('monto_gasto', $orderDir, $orderBy) }}" class="{{ $orderBy === 'monto_gasto' ? 'active' : '' }}">
                                    Monto Gasto
                                    {!! obtenerIconoCaret('monto_gasto', $orderDir, $orderBy) !!}
                                </a>
                            </th>
                            <th class="text-center">
                                <a href="{{ construirURL('updated_at', $orderDir, $orderBy) }}" class="{{ $orderBy === 'updated_at' ? 'active' : '' }}">
                                    Fecha
                                    {!! obtenerIconoCaret('updated_at', $orderDir, $orderBy) !!}
                                </a>
                            </th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gastos as $gasto)
                            <tr id="gasto-{{ $gasto->id }}">
                                <td class="align-baseline" onclick="obtenerSumaGastos({{ $gasto->tipoGasto->id }})">{{ $gasto->tipoGasto->descripcion }}</td>
                                <td class="align-baseline text-end" nowrap>{{Currency::currency("CLP")->format($gasto->monto_gasto,true)}}</td>
                                <td class="align-baseline text-center">{{ date_format($gasto->created_at, "d/m") }}</td>
                                <td class="d-flex align-items-center justify-content-around">
                                    <a href="#" id="despliegaDesc" onclick="despliegaDesc(event,'gasto-{{ $gasto->id }}')" title="Descripcion"><i id="icono-ver-gasto-{{ $gasto->id }}" class="fa-solid fa-eye"></i></a>
                                    <a href="{{url('/gastos/'.$gasto->id.'/edit')}}" title="Editar"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form action="{{ url('/gastos/'. $gasto->id) }}" method="post" id="editaGasto">
                                        @csrf
                                        {{method_field('DELETE')}}
                                        <a onclick="return confirm('Esta seguro de borrar el registro?')" title="Eliminar">
                                            <i class="fa-regular fa-trash-can text-primary"></i>
                                        </a>
                                    </form>
                                </td>
                            </tr>
                            <!-- <tr >
                                <td colspan="4" id="descripciones" style="display:none"></td>
                            </tr> -->
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
function seleccionarOpcion(fecha) {
    // Obtener el valor del mes y año desde la fecha (formato 'm-Y')
    var partes = fecha.split(', ');
    var mesAnno = partes[0];
  
    // Redirigir a la página de estadísticas con los parámetros de mes y año seleccionados
    var url = "{{ url('gastos/estadisticas') }}?mesAnno=" + mesAnno;
    window.location.href = url;
}

        async function despliegaDesc(event,id) {
            event.preventDefault();
          const descripciones = document.getElementById(`descripciones-${id}`);
          if (descripciones === null) {
            const tr_padre = document.getElementById(id);
            const nuevaFila = document.createElement('tr');
            nuevaFila.setAttribute('id', `descripciones-${id}`);
            const nuevoTd = document.createElement('td');
            nuevoTd.setAttribute('colspan', '4');
            nuevaFila.appendChild(nuevoTd);
            tr_padre.after(nuevaFila);
            modificaIcono(id, 'ver');
            nuevoTd.innerHTML = await obtenerDescripciones(id.split('-')[1]);
          } else {
            descripciones.remove();
            modificaIcono(id, 'ocultar');
          }
        }
        
        async function obtenerDescripciones(tipo_gasto_id) {
            var url = "{{ route('get_descripciones_estadisticas', ':gasto_id') }}".replace(':gasto_id', tipo_gasto_id);
            let html = "";
            try {
              const response = await $.ajax({
                url: url,
                method: 'GET'
              });
              html = `<small style="font-weight:bold">Detalles del gasto:</small><br><span>${response[0].join(", ")}</span>`;
            } catch (error) {
              console.log(error);
            }
            return html;
        }

        function modificaIcono(id,evento){
            let icono = document.getElementById("icono-ver-"+id); // seleccionar el elemento por su id
            if(evento == "ver"){
                icono.classList.remove("fa-eye"); // eliminar la clase "fa-eye"
                icono.classList.add("fa-eye-slash");
            }else{
                icono.classList.remove("fa-eye-slash");
                icono.classList.add("fa-eye"); // eliminar la clase "fa-eye"
            }
        }

        function obtenerSumaGastos(idGasto) {
            var selectElement = document.getElementById('formMeses').querySelector('select');
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var idFecha = selectedOption.id;

            // Realizar una solicitud AJAX
            $.ajax({
                url: '/suma-gastos-detalle',
                method: 'GET',
                data: { idGasto: idGasto,
                        idFecha: idFecha },
                success: function(response) {
                    console.log(response)
                    // Manipular los datos recibidos en la respuesta
                    var suma = response.suma;
                    var desc = response.descripcion;

                    // Hacer algo con la suma de gastos (por ejemplo, mostrarla en el front-end)
                    alert('El gasto de '+ desc +' es de: $' + suma);
                },
                error: function(jqXHR) {
                    console.error(jqXHR);
                }
            });
        }
    </script>
    @endauth
</body>
</html>