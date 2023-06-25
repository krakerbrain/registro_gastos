<form action="{{url('/gastos')}}" method="post">
    @csrf
    @include('gastos.form',['modo'=>'Crear'])
</form>
