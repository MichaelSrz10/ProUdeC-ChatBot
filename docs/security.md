# Seguridad (alcance chatbot y app actual)

## Secretos

- `.env` está en `.gitignore`.
- `.env.example` solo tiene valores ficticios (`TU_API_KEY_AQUI`).
- La clave de Gemini se envía en el encabezado `x-goog-api-key`, no en la URL.

## Chatbot

- CSRF en rutas web.
- Throttle por usuario autenticado y por IP de visitante.
- Validación de longitud.
- Filtro previo (`InputGuard`) ante patrones de inyección de prompt.
- Historial acotado en sesión.
- Logging en canal `chatbot` con resultado, idioma y latencia; sin texto del mensaje ni identificadores personales.
- El frontend inserta respuestas como texto, no como HTML.
- Sin acceso a Eloquent de evaluaciones ni a consultas SQL del dominio académico.

## App existente

- Contraseñas con hash (`Hash::make` / cast `hashed`).
- Regeneración de sesión al iniciar sesión.
- Throttle en login (`5` intentos por minuto).
