@include('partials.header')
<div class="row">
    <form action="/register" method="POST" class="form-group col-lg-7 mx-auto">
        @csrf
        <div class="input-group">
            <div class="input-group-text bg-primary text-light">
                <i class="fa-solid fa-user"></i>
            </div>
            <input type="text" name="name" id="name" class="form-control" placeholder="Ingrese un nombre de usuario" ">
        </div>
        <div class="input-group mt-2">
            <div class="input-group-text bg-primary text-light">
                <i class="fa-solid fa-envelope"></i>
            </div>
            <input type="mail" name="email" id="email" class="form-control" placeholder="Ingrese un correo" >
        </div>
        <div class="input-group mt-2">
            <div class="input-group-text bg-primary text-light">
                <i class="fa-solid fa-key"></i>
            </div>
            <input type="password" name="password" id="password" class="form-control" placeholder="Ingrese una clave">
            <div class="input-group-text bg-light">
                <a href="#" class="pe-auto text-primary">
                    <i class="fa-solid fa-eye" onclick="verpass(1)"></i>
                </a>  
            </div>
        </div>
        <div class="input-group mt-2">
            <div class="input-group-text bg-primary text-light">
                <i class="fa-solid fa-key"></i>
            </div>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ingrese otra vez">
            <div class="input-group-text bg-light">
                <a href="#" class="pe-auto text-primary">
                    <i class="fa-solid fa-eye" onclick="verpass(2)"></i>
                </a>  
            </div>
        </div>
        <div class="form-group mt-3">
            <input type="submit" value="Registrar" class="btn btn-primary w-100">
        </div>
        <div>
            <a href="/login">Ir al inicio</a>
        </div>
    </form>
</div>
    <script>
        function verpass(param){
            var pass1 = document.getElementById('password');
            var pass2 = document.getElementById('password2');
            if(param == 1){ 
                pass1.type = pass1.type == "password" ? "text" : "password"
            }else{
                pass2.type = pass2.type == "password" ? "text" : "password"
            }
        }
    </script>
        
</body>
</html>