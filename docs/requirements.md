# Requisitos (estado del repositorio)

## Objetivo

Plataforma web para fortalecer competencias evaluadas en Saber Pro en Ingeniería de Sistemas y Computación, Universidad de Cundinamarca — Seccional Ubaté.

## Requisitos funcionales presentes en el código

1. Visitante puede ver la página de inicio del proyecto.
2. Usuario puede registrarse con nombre, correo y contraseña (mínimo 8 caracteres, confirmación).
3. Usuario puede iniciar y cerrar sesión.
4. Usuario autenticado puede ver el dashboard.
5. Existe un endpoint de contacto con validación de nombre, correo, asunto y mensaje.
6. Existe un asistente informativo (chatbot) sobre ProUDEC, funcionalidades documentadas y la Declaración de la Persona Transhumana.

## Requisitos funcionales comunicados como objetivos (aún no hay motor de evaluación)

La página pública y el dashboard mencionan simulacros, analítica de progreso, retroalimentación y competencias (lectura crítica, razonamiento cuantitativo, competencias ciudadanas, comunicación escrita). Eso expresa la intención del producto. No hay, en el código, motor que genere, califique o almacene esas evaluaciones.

## Requisitos no funcionales

- Aplicación Laravel 12 con Blade y Vite.
- El chatbot no sustituye al docente ni a resultados oficiales.
- El chatbot no accede a datos de otros usuarios ni a resultados individuales.
