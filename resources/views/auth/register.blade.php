<!doctype html>
<html lang="es">
    <head>
        <title>Registro - ProUdeC</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/Icono_ProUdeC_Verde.ico') }}">
        <style>
           body {
                background-image:linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url({{ asset('assets/img/Campus_Ubate_UdeC2.jpg') }});
                background-size: cover;
                background-position: center;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .container {
                display: flex;             
                justify-content: center;    
                align-items: center;        
                width: 100%;              
            }

            .nav-logo {
                height: 150px;            
                width: auto;
                object-fit: contain;
            }
            .signup-card {
                background-color: whitesmoke;
                border: 1px solid #63a20c;
                color: #63a20c;
                max-width: 400px;
                width: 100%;
                padding: 30px;
                border-radius: 10px;
            }
            .form-label {
                color: #63a20c;
            }
            .form-control {
                background-color: #63a20c;
                border: 1px solid #63a20c;
                color: #fff;
            }
            .form-control:focus {
                background-color: #78C20F;
                border-color: #78C20F;
                color: #fff;
            }
            .form-control::placeholder{
                color: rgba(255, 255, 255, 0.736)
            }
            .btn-cyber {
                background-color: #63a20c;
                border-color: #63a20c;
                color: #fff;
                width: 100%;
            }
            .btn-cyber:hover {
                background-color: #fff;
                border-color: #78C20F;
                color: #78C20F;
            }
            a {
                color: #29852F;
            }
            .alert-danger {
                background-color: #63a20c;
                border-color: #63a20c;
                color: #fff;
            }
        </style>
    </head>
    <body>
        <div class="signup-card">
            <div class="container">
                <a href="/">
                    <img src="{{ asset('assets/img/Logo_ProUdeC_Verde.png') }}" class="nav-logo" alt="Logo">
                </a>
            </div>
            <h2 class="text-center mb-4">Crear Cuenta</h2>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Tu nombre" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="tu@ucundinamarca.edu.co" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn btn-cyber">Registrarse</button>
            </form>

            <p class="text-center mt-3">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia Sesión</a>
            </p>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    </body>
</html>
