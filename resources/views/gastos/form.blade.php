<h4>{{$modo}} Gasto</h4>
<br>
<label for="descripcion" >Descripción</label>
<br>
<input class="w-100"type="text" name="descripcion" id="descripcion" value="{{ isset($gastos->descripcion) ? $gastos->descripcion : ''}}">
<br>
<label for="monto_gasto">Monto</label>
<br>
<input class="w-100"type="number" name="monto_gasto" id="monto_gasto" value="{{ isset($gastos->monto_gasto) ? $gastos->monto_gasto : ''}}">
<br>
<input class="btn btn-primary w-100 my-3"type="submit" value="Guardar">
