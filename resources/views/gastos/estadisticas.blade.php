@include('partials.header')
                <div class="d-flex justify-content-between">
                    <h4>Total de gastos </h4>
                    <h4>$ {{$suma}}</h4>
                </div>
                <table class="table table-striped table-bordered small">
                    <thead>
                        <tr>
                            <th class="text-center">Gasto</th>
                            <th class="text-center">Monto Gasto</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gastos as $gasto)
                            <tr id="gasto-{{ $gasto->id }}">
                                <td class="align-baseline">{{ $gasto->tipoGasto->descripcion }}
                                    <a href="#" id="despliegaDesc" onclick="despliegaDesc('gasto-{{ $gasto->id }}')" title="Descripcion"><i id="icono-ver-gasto-{{ $gasto->id }}" class="fa-solid fa-eye"></i></a>
                                </td>
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
        async function despliegaDesc(id) {
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
    </script>
</body>
</html>