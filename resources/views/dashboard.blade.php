<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/Icono_ProUdeC_Blanco.ico') }}">
        <title>Dashboard ProUdeC</title>
        <style>
            *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, Helvetica, sans-serif;
            }
            body{
            display:flex;
            background:#f4f6f9;
            }
            .sidebar{
            width:230px;
            height:100vh;
            background:#113713;
            color:white;
            padding:20px;
            position:fixed;
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
            .sidebar h2{
            margin-bottom:40px;
            text-align:center;
            }
            .sidebar ul{
            list-style:none;
            }
            .sidebar ul li{
            padding:12px;
            margin:10px 0;
            cursor:pointer;
            border-radius:5px;
            }
            .sidebar ul li:hover{
            background:#63a20c;
            }
            .main{
            margin-left:230px;
            width:100%;
            padding:20px;
            }
            .header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:30px;
            }
            .user{
            background:white;
            padding:8px 15px;
            border-radius:5px;
            box-shadow:0 2px 5px    rgba(0, 0, 0, 0.1);
            }
            .cards{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
            gap:20px;
            margin-bottom:30px;
            }

            .card{
            background:white;
            padding:20px;
            border-radius:8px;
            box-shadow:0 2px 5px rgba(0,0,0,0.1);
            }

            .card h3{
            margin-bottom:10px;
            color:#374151;
            }
            .card p{
            font-size:22px;
            font-weight:bold;
            }
            .content{
            display:grid;
            grid-template-columns:2fr 1fr;
            gap:20px;
            }
            .chart{
            background:white;
            padding:20px;
            border-radius:8px;
            box-shadow:0 2px 5px rgba(0,0,0,0.1);
            }
            .chart-bar{
            height:150px;
            display:flex;
            align-items:flex-end;
            gap:10px;
            margin-top:20px;
            }
            .bar{
            width:30px;
            background:#63a20c;
            border-radius:4px;
            }
            .activity{
            background:white;
            padding:20px;
            border-radius:8px;
            box-shadow:0 2px 5px rgba(0,0,0,0.1);
            }
            .activity ul{
            list-style:none;
            }
            .activity li{
            padding:10px 0;
            border-bottom:1px solid #eee;
            }
            .simulacros{
            margin-top:30px;
            background:white;
            padding:20px;
            border-radius:8px;
            box-shadow:0 2px 5px rgba(0,0,0,0.1);
            }
            table{
            width:100%;
            border-collapse:collapse;
            margin-top:10px;
            }
            th,td{
            padding:10px;
            text-align:left;
            border-bottom:1px solid #ddd;
            }
            th{
            background:#f1f1f1;
            }
            button{
            padding:6px 12px;
            background:#63a20c;
            color:white;
            border:none;
            border-radius:4px;
            cursor:pointer;
            }
            button:hover{
            background:#78C20F;
            }

        </style>
    </head>

    <body>
        <div class="sidebar">
            <div class="container">
                <a href="/">
                    <img src="{{ asset('assets/img/Logo_ProUdeC_Blanco.png') }}" class="nav-logo" alt="Logo">
                </a>
            </div>
            <h2>Menu</h2>
            <ul>
                <li>Dashboard</li>
                <li>Contenidos</li>
                <li>Simulacros</li>
                <li>Resultados</li>
                <li>Perfil</li>
                <li>Configuración</li>
            </ul>
        </div>
        <div class="main">
            <div class="header">
                <h1>Dashboard</h1>
                <div class="user">
                    Bienvenido {{ Auth::user()->name ?? 'Estudiante' }}
                </div>
                <div class="d-flex">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light" style="background-color:#113713; border-color: #113713;color: white;">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
            <div class="cards">
                <div class="card">
                    <h3>Simulacros realizados</h3>
                    <p>12</p>
                </div>
                <div class="card">
                    <h3>Puntaje promedio</h3>
                    <p>148</p>
                </div>
                <div class="card">
                    <h3>Competencias completadas</h3>
                    <p>4 / 5</p>
                </div>
                <div class="card">
                    <h3>Ranking interno</h3>
                    <p>#8</p>
                </div>
            </div>
            <div class="content">
                <div class="chart">
                    <h3>Progreso en simulacros</h3>
                    <div class="chart-bar">
                    <div class="bar" style="height:80px"></div>
                    <div class="bar" style="height:120px"></div>
                    <div class="bar" style="height:60px"></div>
                    <div class="bar" style="height:140px"></div>
                    <div class="bar" style="height:100px"></div>
                </div>
            </div>
            <div class="activity">
                <h3>Actividad reciente</h3>
                <ul>
                    <li>Realizaste simulacro de Lectura Crítica</li>
                    <li>Nuevo contenido agregado en Razonamiento Cuantitativo</li>
                    <li>Simulacro completado con puntaje 152</li>
                    <li>Actualizaste tu perfil</li>
                </ul>
            </div>
        </div>
        <div class="simulacros">
            <h3>Simulacros disponibles</h3>
            <table>
                <tr>
                    <th>Competencia</th>
                    <th>Preguntas</th>
                    <th>Tiempo</th>
                    <th>Acción</th>
                </tr>
                <tr>
                    <td>Lectura Crítica</td>
                    <td>20</td>
                    <td>30 min</td>
                    <td><button>Iniciar</button></td>
                </tr>
                <tr>
                    <td>Razonamiento Cuantitativo</td>
                    <td>20</td>
                    <td>30 min</td>
                    <td><button>Iniciar</button></td>
                </tr>
                <tr>
                    <td>Competencias Ciudadanas</td>
                    <td>20</td>
                    <td>30 min</td>
                    <td><button>Iniciar</button></td>
                </tr>
                <tr>
                    <td>Comunicación Escrita</td>
                    <td>1 Ensayo</td>
                    <td>40 min</td>
                    <td><button>Iniciar</button></td>
                </tr>
            </table>

        </div>
    </body>
</html>
