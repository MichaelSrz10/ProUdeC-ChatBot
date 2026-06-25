<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/Icono_ProUdeC_Verde.ico') }}">
        <title>ProUdeC | Plataforma Saber Pro</title>

        <!-- ICONOS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <!-- GOOGLE FONT -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <style>

            *{
                margin:0;
                padding:0;
                box-sizing:border-box;
                scroll-behavior:smooth;
            }

            :root{
                --primary:#63a20c;
                --secondary:#113713;
                --light:#f5f7f2;
                --white:#ffffff;
                --gray:#6b7280;
                --shadow:0 10px 30px rgba(0,0,0,0.08);
            }

            body{
                font-family:'Inter', sans-serif;
                background:var(--light);
                color:#1f2937;
                overflow-x:hidden;
            }

            /* NAVBAR */

            .navbar{
                position:fixed;
                top:0;
                left:0;
                width:100%;
                padding:18px 8%;
                display:flex;
                justify-content:space-between;
                align-items:center;
                backdrop-filter: blur(10px);
                background:rgba(17,55,19,0.92);
                z-index:1000;
            }

            .nav-logo{
                height:50px;
                transition:0.3s;
            }

            .nav-logo:hover{
                transform:scale(1.05);
            }

            .nav-links{
                display:flex;
                list-style:none;
                gap:35px;
                align-items:center;
            }

            .nav-links a{
                text-decoration:none;
                color:white;
                font-size:15px;
                font-weight:500;
                position:relative;
                transition:0.3s;
            }

            .nav-links a::after{
                content:'';
                position:absolute;
                width:0%;
                height:2px;
                background:var(--primary);
                left:0;
                bottom:-6px;
                transition:0.3s;
            }

            .nav-links a:hover::after{
                width:100%;
            }

            .nav-links a:hover{
                color:var(--primary);
            }

            .btn{
                padding:12px 22px;
                background:var(--primary);
                border-radius:12px;
                color:white !important;
                box-shadow:var(--shadow);
                transition:0.3s;
            }

            .btn:hover{
                transform:translateY(-2px);
                background:#7cc212;
            }

            /* HERO */

            .hero{
                min-height:100vh;
                display:flex;
                align-items:center;
                justify-content:space-between;
                padding:120px 8% 80px;
                gap:50px;
                background:
                radial-gradient(circle at top right, rgba(99,162,12,0.2), transparent 30%),
                radial-gradient(circle at bottom left, rgba(17,55,19,0.15), transparent 25%);
            }

            .hero-text{
                flex:1;
            }

            .hero-text h1{
                font-size:65px;
                color:var(--secondary);
                margin-bottom:20px;
                line-height:1.1;
            }

            .hero-text span{
                color:var(--primary);
            }

            .hero-text p{
                font-size:18px;
                line-height:1.8;
                color:var(--gray);
                max-width:650px;
                margin-bottom:35px;
            }

            .hero-buttons{
                display:flex;
                gap:20px;
                flex-wrap:wrap;
            }

            .primary-btn{
                padding:15px 28px;
                border:none;
                border-radius:14px;
                background:var(--primary);
                color:white;
                text-decoration:none;
                font-weight:600;
                transition:0.3s;
                box-shadow:var(--shadow);
            }

            .primary-btn:hover{
                transform:translateY(-3px);
            }

            .secondary-btn{
                padding:15px 28px;
                border-radius:14px;
                border:2px solid var(--primary);
                text-decoration:none;
                color:var(--primary);
                font-weight:600;
                transition:0.3s;
            }

            .secondary-btn:hover{
                background:var(--primary);
                color:white;
            }

            /* HERO CARD */

            .hero-card{
                flex:1;
                display:flex;
                justify-content:center;
            }

            .dashboard-preview{
                width:100%;
                max-width:500px;
                background:white;
                border-radius:28px;
                padding:30px;
                box-shadow:0 20px 50px rgba(0,0,0,0.12);
                animation:float 5s ease-in-out infinite;
            }

            @keyframes float{
                0%{transform:translateY(0px);}
                50%{transform:translateY(-12px);}
                100%{transform:translateY(0px);}
            }

            .mini-card{
                background:#f7f9f4;
                padding:18px;
                border-radius:18px;
                margin-bottom:18px;
            }

            .mini-card h3{
                color:var(--secondary);
                margin-bottom:10px;
            }

            .progress{
                width:100%;
                height:10px;
                background:#dfe7d5;
                border-radius:10px;
                overflow:hidden;
            }

            .progress div{
                width:75%;
                height:100%;
                background:var(--primary);
            }

            /* SECTION */

            section{
                padding:110px 8%;
            }

            .section-header{
                text-align:center;
                margin-bottom:70px;
            }

            .section-header h2{
                font-size:42px;
                color:var(--secondary);
                margin-bottom:15px;
            }

            .section-header p{
                color:var(--gray);
                max-width:700px;
                margin:auto;
                line-height:1.7;
            }

            /* CARDS */

            .cards{
                display:grid;
                grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
                gap:30px;
            }

            .card{
                background:white;
                border-radius:24px;
                padding:35px;
                transition:0.4s;
                box-shadow:0 5px 20px rgba(0,0,0,0.05);
                border:1px solid transparent;
            }

            .card:hover{
                transform:translateY(-8px);
                border-color:rgba(99,162,12,0.3);
                box-shadow:0 15px 40px rgba(0,0,0,0.08);
            }

            .card-icon{
                width:65px;
                height:65px;
                border-radius:18px;
                background:rgba(99,162,12,0.12);
                display:flex;
                align-items:center;
                justify-content:center;
                margin-bottom:20px;
            }

            .card-icon i{
                font-size:28px;
                color:var(--primary);
            }

            .card h3{
                margin-bottom:15px;
                color:var(--secondary);
            }

            .card p{
                color:var(--gray);
                line-height:1.8;
            }

            /* STATS */

            .stats{
                background:linear-gradient(135deg, #113713, #1d5220);
                color:white;
                border-radius:35px;
                margin:0 8%;
                padding:60px;
                display:grid;
                grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
                gap:30px;
                text-align:center;
            }

            .stat h2{
                font-size:50px;
                color:#9fe22f;
            }

            .stat p{
                margin-top:10px;
                color:#d1d5db;
            }

            /* FOOTER */

            footer{
                margin-top:100px;
                padding:40px;
                text-align:center;
                background:var(--secondary);
                color:white;
            }

            footer p{
                opacity:0.8;
                margin-top:10px;
            }

            /* RESPONSIVE */

            @media(max-width:950px){

                .hero{
                    flex-direction:column;
                    text-align:center;
                }

                .hero-text h1{
                    font-size:48px;
                }

                .hero-buttons{
                    justify-content:center;
                }

                .nav-links{
                    gap:18px;
                }

                .navbar{
                    padding:18px 5%;
                }

                section{
                    padding:90px 5%;
                }

                .stats{
                    margin:0 5%;
                }

            }

        </style>

    </head>

    <body>

        <!-- NAVBAR -->

        <nav class="navbar">

            <a href="/">
                <img src="{{ asset('assets/img/Logo_ProUdeC_Blanco.png') }}" class="nav-logo">
            </a>

            <ul class="nav-links">
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#proyecto">Proyecto</a></li>
                <li><a href="#beneficios">Beneficios</a></li>
                <li><a href="#objetivos">Objetivos</a></li>
                <li><a href="/login">Login</a></li>
                <li><a href="/register" class="btn">Register</a></li>
            </ul>

        </nav>

        <!-- HERO -->

        <section class="hero" id="inicio">

            <div class="hero-text">

                <h1>
                    Impulsa tus resultados en
                    <span>Saber Pro</span>
                </h1>

                <p>
                    ProUdeC es una plataforma educativa desarrollada para fortalecer las competencias genéricas y específicas de los estudiantes de Ingeniería de Sistemas y Computación de la Universidad de Cundinamarca mediante simulacros, analítica y retroalimentación inteligente.
                </p>

                <div class="hero-buttons">

                    <a href="/register" class="primary-btn">
                        Comenzar Ahora
                    </a>

                    <a href="#proyecto" class="secondary-btn">
                        Conocer Más
                    </a>

                </div>

            </div>

            <div class="hero-card">

                <div class="dashboard-preview">

                    <div class="mini-card">
                        <h3>Progreso General</h3>

                        <div class="progress">
                            <div></div>
                        </div>
                    </div>

                    <div class="mini-card">
                        <h3>
                            <i class="fa-solid fa-chart-line"></i>
                            Puntaje Promedio
                        </h3>
                        <p>146 → 155 puntos</p>
                    </div>

                    <div class="mini-card">
                        <h3>
                            <i class="fa-solid fa-book-open"></i>
                            Simulacros Disponibles
                        </h3>
                        <p>+120 preguntas categorizadas</p>
                    </div>

                </div>

            </div>

        </section>

        <!-- PROYECTO -->

        <section id="proyecto">

            <div class="section-header">

                <h2>¿Qué es ProUdeC?</h2>

                <p>
                    Una solución tecnológica enfocada en fortalecer el desempeño académico de los estudiantes mediante herramientas digitales modernas, prácticas y accesibles.
                </p>

            </div>

            <div class="cards">

                <div class="card">

                    <div class="card-icon">
                        <i class="fa-solid fa-laptop-code"></i>
                    </div>

                    <h3>Plataforma Web</h3>

                    <p>
                        Sistema interactivo diseñado para preparar estudiantes en competencias Saber Pro mediante simulacros y recursos académicos.
                    </p>

                </div>

                <div class="card">

                    <div class="card-icon">
                        <i class="fa-solid fa-brain"></i>
                    </div>

                    <h3>Aprendizaje Inteligente</h3>

                    <p>
                        Retroalimentación inmediata y seguimiento continuo del progreso académico según el rendimiento del estudiante.
                    </p>

                </div>

                <div class="card">

                    <div class="card-icon">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>

                    <h3>Enfoque Universitario</h3>

                    <p>
                        Adaptado al programa de Ingeniería de Sistemas y Computación de la Universidad de Cundinamarca.
                    </p>

                </div>

            </div>

        </section>

        <!-- STATS -->

        <div class="stats">

            <div class="stat">
                <h2>+120</h2>
                <p>Preguntas Registradas</p>
            </div>

            <div class="stat">
                <h2>8</h2>
                <p>Competencias Evaluadas</p>
            </div>

            <div class="stat">
                <h2>24/7</h2>
                <p>Acceso Permanente</p>
            </div>

            <div class="stat">
                <h2>100%</h2>
                <p>Enfocado en Saber Pro</p>
            </div>

        </div>

        <!-- BENEFICIOS -->

        <section id="beneficios">

            <div class="section-header">

                <h2>¿Por qué usar ProUdeC?</h2>

                <p>
                    La plataforma busca mejorar el rendimiento académico mediante experiencias digitales modernas y dinámicas.
                </p>

            </div>

            <div class="cards">

                <div class="card">

                    <div class="card-icon">
                        <i class="fa-solid fa-clipboard-check"></i>
                    </div>

                    <h3>Simulacros Reales</h3>

                    <p>
                        Evaluaciones similares a las pruebas Saber Pro para fortalecer la preparación de los estudiantes.
                    </p>

                </div>

                <div class="card">

                    <div class="card-icon">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>

                    <h3>Analítica de Progreso</h3>

                    <p>
                        Estadísticas visuales y reportes personalizados para identificar fortalezas y debilidades.
                    </p>

                </div>

                <div class="card">

                    <div class="card-icon">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>

                    <h3>Retroalimentación</h3>

                    <p>
                        Recomendaciones y acompañamiento académico basado en el desempeño obtenido.
                    </p>

                </div>

            </div>

        </section>

        <!-- OBJETIVOS -->

        <section id="objetivos">

            <div class="section-header">

                <h2>Objetivos del Proyecto</h2>

                <p>
                    ProUdeC busca fortalecer la preparación académica y apoyar el proceso institucional de mejoramiento continuo.
                </p>

            </div>

            <div class="cards">

                <div class="card">

                    <div class="card-icon">
                        <i class="fa-solid fa-magnifying-glass-chart"></i>
                    </div>

                    <h3>Analizar Competencias</h3>

                    <p>
                        Identificar falencias en competencias genéricas y específicas evaluadas en Saber Pro.
                    </p>

                </div>

                <div class="card">

                    <div class="card-icon">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>

                    <h3>Integrar Módulos</h3>

                    <p>
                        Simulacros, banco de preguntas, contenidos multimedia y paneles de desempeño.
                    </p>

                </div>

                <div class="card">

                    <div class="card-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>

                    <h3>Validar Calidad</h3>

                    <p>
                        Evaluar funcionalidad, rendimiento y aceptación mediante pruebas piloto y métricas.
                    </p>

                </div>

            </div>

        </section>

        <!-- FOOTER -->

        <footer>

            <h3>ProUdeC</h3>

            <p>
                Plataforma para el fortalecimiento de competencias Saber Pro
            </p>

            <p>
                Universidad de Cundinamarca - Ingeniería de Sistemas y Computación
            </p>

        </footer>

    </body>

</html>