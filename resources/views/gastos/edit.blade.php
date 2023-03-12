                @include('partials.header', ['index'=> ''])
                <form action="{{url('/gastos/'.$gastos->id)}}" method="post">
                @csrf
                {{method_field('PATCH')}}
                    @include('gastos.form',['modo'=>'Editar'])
                </form>
            </div>
        </div>
    </div>
</body>
</html>