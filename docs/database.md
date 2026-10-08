# Base de datos

Migraciones incluidas en el proyecto (Laravel por defecto más el uso de sesión/caché/colas):

- `users`: id, name, email único, email_verified_at, password, remember_token, timestamps
- `password_reset_tokens`
- `sessions`
- `cache` / `cache_locks`
- `jobs` / `job_batches` / `failed_jobs`

No hay tablas de preguntas, intentos, competencias, recursos, notificaciones ni roles.

El `.env.example` usa `DB_CONNECTION=sqlite` por defecto. El plan de despliegue puede usar MySQL; eso no cambia el esquema del chatbot, que no persiste conocimiento en SQL.
