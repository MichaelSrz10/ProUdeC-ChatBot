# ProUdeC — Arquitectura

## 1. Arquitectura objetivo

ProUdeC utilizará una aplicación web monolítica modular basada en:

- Laravel 12
- PHP
- MySQL 8.4
- Blade
- CSS
- JavaScript
- Vite
- Tailwind CSS dentro de la configuración existente

La arquitectura seguirá el patrón MVC de Laravel, con servicios/clases especializadas cuando la lógica de negocio exceda la responsabilidad razonable de un controlador o modelo.

## 2. Principios

1. Seguridad primero.
2. Integridad histórica.
3. Separación de responsabilidades.
4. Bajo acoplamiento.
5. Alta cohesión.
6. Testabilidad.
7. Reutilización.
8. Simplicidad.
9. Trazabilidad.
10. No introducir complejidad sin necesidad.

## 3. Capas lógicas

```text
Browser
  ↓
Routes
  ↓
Middleware / Authorization
  ↓
Controllers
  ↓
Application / Domain Services
  ↓
Eloquent Models
  ↓
MySQL
```

Las vistas Blade y JavaScript forman la capa de presentación.

## 4. Controladores

Los controladores:

- reciben la petición;
- validan mediante Form Requests cuando sea apropiado;
- autorizan;
- delegan lógica;
- devuelven respuesta.

Evitar lógica de negocio extensa.

## 5. Servicios

Utilizar servicios para operaciones complejas como:

- inicio de intentos;
- selección de preguntas;
- generación de snapshots;
- cálculo de resultados;
- asignación de calificadores;
- gestión de intentos adicionales;
- generación de evaluaciones;
- operaciones que requieran transacciones complejas.

No crear servicios artificiales para operaciones triviales.

## 6. Autorización

Usar:

- Middleware para restricciones generales.
- Policies para autorización sobre recursos.
- Gates cuando exista una regla transversal apropiada.

Nunca depender de controles frontend.

## 7. Base de datos

MySQL 8.4, InnoDB y utf8mb4.

Las migraciones de Laravel son la fuente de definición estructural del esquema.

## 8. Entidades principales

```text
roles
users
notifications
audit_logs

competencies
teacher_competencies
learning_topics
resources
student_resource_progress

questions
question_options

evaluations
evaluation_question_rules
evaluation_students

assigned_evaluation_questions
assigned_evaluation_question_options

attempts
attempt_questions
attempt_question_options
attempt_answers

grading_assignments

additional_attempt_requests
additional_attempts
```

## 9. Regla de snapshots

Al iniciar un intento se congelan:

- preguntas;
- enunciados;
- opciones;
- orden;
- condiciones necesarias.

Los intentos históricos no dependen de la versión actual de una pregunta.

## 10. Regla de intentos

Solo un intento IN_PROGRESS por estudiante/evaluación.

La creación debe ser segura ante concurrencia y utilizar transacciones.

## 11. Flujo de evaluación

```text
Pre-start
→ Transaction
→ Validate availability
→ Create attempt
→ Select questions
→ Create snapshots
→ Create answer records
→ Commit
→ Student starts
```

Si no existen suficientes preguntas elegibles, no se crea un intento parcialmente configurado.

## 12. Tiempo

El backend es la autoridad.

El frontend muestra el tiempo restante, pero no determina cuándo termina una evaluación.

Al expirar:

```text
IN_PROGRESS → AUTO_SUBMITTED
```

## 13. Integridad histórica

No utilizar cascadas destructivas sobre registros académicos.

Las desactivaciones deben preservar historial.

## 14. Frontend

Blade será la capa principal.

JavaScript se utilizará para:

- temporizador visual;
- navegación de preguntas;
- modales;
- filtros;
- interacción;
- componentes dinámicos;
- gráficas y visualizaciones cuando sean necesarias.

El backend sigue siendo autoridad.

## 15. Componentización

Reutilizar:

- layouts;
- componentes Blade;
- formularios;
- tablas;
- modales;
- mensajes;
- indicadores;
- navegación.

No crear una SPA independiente.

## 16. Dependencias

No agregar paquetes sin justificación.

Antes de agregar uno:

1. comprobar capacidades nativas;
2. revisar dependencias existentes;
3. evaluar seguridad;
4. evaluar mantenimiento;
5. evaluar impacto arquitectónico.

## 17. Transacciones

Usar transacciones para operaciones críticas que involucren múltiples tablas.

Especialmente:

- inicio de intento;
- selección/snapshot;
- decisiones de intentos adicionales;
- reasignación de calificación;
- operaciones administrativas críticas.

## 18. Eventos y colas

No introducir una arquitectura de eventos/colas compleja sin necesidad.

Si posteriormente se requiere procesamiento asíncrono, documentar la razón antes de incorporarlo.

## 19. API

No crear una API separada por defecto.

Las rutas web de Laravel son suficientes para el alcance actual.

## 20. Regla de evolución

Una modificación que cambie esta arquitectura debe registrarse en `decisions.md` y requerir autorización antes de implementarse.
