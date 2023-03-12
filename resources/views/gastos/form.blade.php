
<fieldset style="all:revert;" class="mb-3">
    <legend style="all:revert">Gastos más frecuentes</legend>
<div class="d-flex flex-wrap">
    @foreach($populares as $popular)
    <div class="col-md col-6">
        <button style="width:85%" class="btn btn-primary btn-descripcion btn-sm mb-1" data-descripcion="{{ $popular->descripcion }}">{{ $popular->descripcion }}</button>
    </div>
    @endforeach
</div>
</fieldset>

<label for="descripcion" >Descripción</label>
<br>
<input class="w-100"type="text" name="descripcion" id="descripcion" value="{{ isset($gastos->descripcion) ? $gastos->descripcion : ''}}">
<br>
<label for="monto_gasto">Monto</label>
<br>
<input class="w-100"type="number" name="monto_gasto" id="monto_gasto" value="{{ isset($gastos->monto_gasto) ? $gastos->monto_gasto : ''}}">
<br>
<input class="btn btn-primary w-100 my-3"type="submit" value="{{$modo}} gasto">
<script>
$(function() {
    $( "#descripcion" ).autocomplete({
        source: "{{ route('autocomplete') }}",
        minLength: 2,
        select: function(event, ui) {
            $('#descripcion').val(ui.item.value);
            $('#monto_gasto').focus();
        }
    });
});

    // Seleccionar los botones por su clase y agregar un evento click
    $('.btn-descripcion').click(function(e) {
        e.preventDefault()
        // Obtener la descripción desde el atributo data-descripcion del botón
        var descripcion = $(this).data('descripcion');
        // Establecer el valor del campo de descripción
        $('#descripcion').val(descripcion);
    });

</script>
