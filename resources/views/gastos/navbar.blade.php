<!-- resources/views/welcome.blade.php -->
@vite(['resources/scss/app.scss', 'resources/js/app.js'])

<ul class="nav nav-pills nav-justified">
  <li class="nav-item">
    <a class="nav-link {{$index == 'gastos/estadisticas' ? '' : 'active'}}" aria-current="page" href="{{url('gastos/')}}">Inicio</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{$index == 'gastos/estadisticas' ? 'active' : ''}}" href="{{url('gastos/estadisticas')}}">Estadísticas</a>
  </li>
</ul>