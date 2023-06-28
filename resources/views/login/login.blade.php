@include('partials.header')
    @guest
    <div class="row">
    <form action="/login" method="POST" class="form-group col-lg-7 mx-auto">
        @csrf
        <div class="input-group">
            <div class="input-group-text bg-primary text-light">
              <i class="fa-solid fa-user"></i>
            </div>
            <input type="text" name="name" id="name" class="form-control" placeholder="Ingrese usuario o correo">
          </div>
          <div class="input-group mt-3">
            <div class="input-group-text bg-primary text-light">
              <i class="fa-solid fa-key"></i>
            </div>
            <input type="password" name="password" id="password" class="form-control" placeholder="Ingrese su contraseña">
            <div class="input-group-text bg-light">
              <a href="#" class="pe-auto text-primary">
                  <i class="fa-solid fa-eye" onclick="verpass()"></i>
              </a>  
            </div>
          </div>
          <div class="form-group  mt-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">
                    Recordarme
                </label>
            </div>
          </div>       
          <div class="form-group mt-3">
            <input type="submit" value="Login" class="btn btn-primary w-100">
          </div> 
    </form>
    <div class="d-flex gap-1 justify-content-center mt-1">
        <div style="margin-right:5px">¿No tiene una cuenta?</div>
        <a href="/register" class="text-decoration-none text-primary fw-semibold">Registrese</a>
      </div>
</div>    
    <script>
        function verpass(){
            var pass = document.getElementById('password');
            pass.type = pass.type == "password" ? "text" : "password"
        }
    </script>
    @endguest
    

</body>
</html>