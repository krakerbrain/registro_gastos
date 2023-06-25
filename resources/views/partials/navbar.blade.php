<!-- resources/views/welcome.blade.php -->
@vite(['resources/scss/app.scss', 'resources/js/app.js'])

@auth
<nav class="navbar navbar-dark bg-primary mb-3">
  <a class="navbar-brand ms-2" href="#">Gastos de {{ auth()->user()->name}}</a>
  <a href="/logout" class="text-light me-2">Cerrar sesión</a>
</nav>
<ul class="nav nav-pills nav-justified mb-3">
  <li class="nav-item">
    <a class="nav-link {{$index == 'gastos/estadisticas' ? '' : 'active'}}" aria-current="page" href="{{url('gastos/')}}">Inicio</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{$index == 'gastos/estadisticas' ? 'active' : ''}}" href="{{url('gastos/estadisticas')}}">Estadísticas</a>
  </li>
</ul>
@endauth  
@guest
<nav class="navbar navbar-dark bg-primary mb-3">
  <a href="#" class="text-light text-decoration-none mx-auto">SISTEMA DE REGISTRO DE GASTOS</a>
</nav>
@endguest
