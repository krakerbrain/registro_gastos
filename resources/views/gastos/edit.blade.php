<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

@include('gastos.navbar', ['index'=> ''])
<form action="{{url('/gastos/'.$gastos->id)}}" method="post">
    @csrf
    {{method_field('PATCH')}}
    @include('gastos.form',['modo'=>'Editar'])
</form>
</body>
</html>