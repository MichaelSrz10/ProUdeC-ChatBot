# Arquitectura

## Aplicación

- Framework: Laravel 12 (`laravel/framework ^12.0`)
- PHP requerido por Composer: `^8.2`
- Vistas: Blade
- Front: Vite 7 y Tailwind CSS 4 (entrada `resources/css/app.css`; el widget del chatbot usa CSS acotado para no alterar las vistas existentes)
- Autenticación de sesión Laravel (login, registro, logout)

## Módulo chatbot (capas)

1. Widget Blade + JavaScript (Vite) envía `POST /chatbot/message` con CSRF.
2. `ChatbotController` orquesta; no consulta modelos Eloquent de evaluación.
3. `InputGuard` filtra entradas inválidas o de inyección.
4. `ConversationMemory` guarda turnos en sesión (acotados).
5. `KnowledgeBase` carga JSON cacheados en memoria de proceso.
6. `PromptBuilder` arma `system_instruction` y `contents`.
7. `GeminiClient` llama a `generateContent` con encabezado `x-goog-api-key`.

## Persistencia

Migraciones vigentes: `users`, `password_reset_tokens`, `sessions`, `cache`, `jobs`. El chatbot no agrega esquema.
