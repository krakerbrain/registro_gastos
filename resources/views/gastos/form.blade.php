@auth
    
@if (isset($populares))
<fieldset style="all:revert;" class="mb-3">
    <legend style="all:revert">Gastos más frecuentes</legend>
    <div class="d-flex flex-wrap">
        @foreach($populares as $tipoGasto)
        <div class="col-md col-6">
            <button style="width:85%" class="btn btn-primary btn-masfrecuente btn-sm mb-1" data-id="{{$tipoGasto->id}}" data-descripcion="{{ $tipoGasto->descripcion }}">{{ $tipoGasto->descripcion }}</button>
        </div>
        @endforeach
    </div>
</fieldset>
@endif

<label for="monto_gasto">Monto</label>
<br>
<input class="w-100"type="number" name="monto_gasto" id="monto_gasto" value="{{ isset($gastos->monto_gasto) ? $gastos->monto_gasto : ''}}">
<br>
<label for="tipoGasto" >Tipo Gasto</label>
<br>
<input class="w-100"type="text" name="tipoGasto" id="tipoGasto" value="{{ isset($gastos->tipo_gasto) ? $gastos->tipo_gasto : ''}}"  {{ $modo == 'Editar' ? 'disabled' : '' }}>
<br>
<label for="descripcion" >Descripción <small style="color:red">Ingresar descripciones separadas por coma</small></label>
<br>
<input class="w-100" type="text" name="descripcion" id="descripcion" value="{{ isset($gastos->descripcion_gasto) ? $gastos->descripcion_gasto : ''}}" placeholder="Ejm: 'comida, utiles escolares'" {{ $modo == 'Editar' ? 'onfocus="obtenerDescripciones('.$gastos->tipo_gasto_id.')"': '' }}>
<br>
<div id="desc"></div>
<input class="btn btn-primary w-100 my-3"type="submit" value="{{$modo}} gasto">
<script>
    
    $(function() {
        $( "#tipoGasto" ).autocomplete({
            source: "{{ route('autocomplete') }}",
            minLength: 2,
            select: function(event, ui) {
            $('#tipoGasto').val(ui.item.value);
            $('#tipoGasto').data('id', ui.item.id);
            $('#descripcion').focus();
            
        }
    });
});

// Agregar evento de clic a los botones btn-desc
$('#desc').on('click', '#btn-desc', function(e) {
    e.preventDefault();
    // Obtener el valor del botón
    let descripcion = this.textContent;
    // Obtener el valor actual del input descripcion
    let descripcionActual = document.querySelector('#descripcion').value;
    if (descripcionActual.endsWith(',')) {
        descripcionActual = descripcionActual.slice(0, -1); // Eliminar la coma al final
    }
    // Concatenar el valor del botón al valor actual del input descripcion
    let descripcionNueva = descripcionActual ? descripcionActual + ', ' + descripcion : descripcion;
    // Establecer el valor del input descripcion
    $('#descripcion').val(descripcionNueva);
        // Eliminar el botón que se está presionando
        $(this).remove();
});

// Seleccionar los botones por su clase y agregar un evento click
$('.btn-masfrecuente').click(function(e) {
    e.preventDefault()
    // Obtener la descripción desde el atributo data-descripcion del botón
    var descripcion = $(this).data('descripcion');
    // Establecer el valor del campo de descripción
    $('#tipoGasto').val(descripcion);
    activarBotones($(this).data('id'))
    $('descripcion').focus();
});

function obtenerDescripciones(tipo_gasto_id) {
    var url = "{{ route('get_descripciones', ':tipo_gasto_id') }}".replace(':tipo_gasto_id', tipo_gasto_id);
    $.ajax({
        url: url,
        method: 'GET',
        success: function(response) {
            desc.innerHTML = "";
            for (let i = 0; i < response[0].length; i++) {
                desc.innerHTML += `<button class="btn btn-primary btn-sm m-1" id="btn-desc">${response[0][i]}</button>`
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}

$('#tipoGasto').on('change', function(e) {
    e.preventDefault()
    var tipo_gasto_id = $(this).data('id');
    obtenerDescripciones(tipo_gasto_id);
});

function activarBotones(id) {
    obtenerDescripciones(id);
}


</script>

@endauth