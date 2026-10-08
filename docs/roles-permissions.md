# Roles y permisos

## Estado implementado

El modelo `User` tiene `name`, `email` y `password`. No existe campo `role` ni políticas por rol (estudiante, docente, administrador) en el código.

Cualquier usuario autenticado accede al dashboard. Visitantes acceden a inicio, login y registro.

## Intención de producto (no modelada en datos)

La interfaz del dashboard muestra secciones de contenidos, simulacros, resultados, perfil y configuración. La página pública se dirige a estudiantes del programa. El chatbot ofrece el mismo conocimiento a visitantes y a usuarios autenticados: no personaliza respuestas con datos del usuario.

## Chatbot

- Visitantes y usuarios autenticados pueden usarlo.
- Los visitantes tienen un límite de peticiones por minuto más estricto (por IP).
- El bot no concede permisos ni consulta autorización de evaluación.
