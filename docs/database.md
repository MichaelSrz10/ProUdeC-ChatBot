# ProUdeC — Diseño de base de datos

## 1. Motor

- MySQL 8.4
- InnoDB
- utf8mb4
- BIGINT UNSIGNED para PK/FK salvo justificación explícita

## 2. Tablas

### Seguridad y usuarios

- `roles`
- `users`
- `notifications`
- `audit_logs`

### Contenido académico

- `competencies`
- `teacher_competencies`
- `learning_topics`
- `resources`
- `student_resource_progress`

### Preguntas

- `questions`
- `question_options`

### Evaluaciones

- `evaluations`
- `evaluation_question_rules`
- `evaluation_students`
- `assigned_evaluation_questions`
- `assigned_evaluation_question_options`

### Ejecuciones

- `attempts`
- `attempt_questions`
- `attempt_question_options`
- `attempt_answers`

### Calificación

- `grading_assignments`

### Intentos adicionales

- `additional_attempt_requests`
- `additional_attempts`

## 3. Roles

`roles` contiene exactamente los cuatro roles estructurales:

- ESTUDIANTE
- DOCENTE
- COORDINADOR
- SUPERADMIN

Debe existir exactamente un SuperAdmin.

## 4. Users

Campos conceptuales:

- id
- role_id
- first_name
- last_name
- email
- password
- email_verified_at
- is_active
- institutional_code
- last_login_at
- timestamps

El email es único incluso si el usuario está inactivo.

## 5. Competencias

Cada competencia puede tener:

- preguntas;
- recursos;
- temas;
- autorizaciones docentes;
- evaluaciones asociadas.

Cada pregunta pertenece a exactamente una competencia.

## 6. Teacher competencies

`teacher_competencies` implementa la relación N:M:

```text
teacher ↔ competency
```

Si un docente pierde autorización, el historial no se elimina.

## 7. Learning topics

Cada tema pertenece a una competencia.

Cada competencia tiene un tema especial:

`Recursos Adicionales`

Ese tema no puede eliminarse.

Tiene orden configurable y debe aparecer al final.

## 8. Resources

Cada recurso:

- pertenece a una competencia;
- puede pertenecer a un tema;
- tiene creador;
- tiene estado;
- almacena metadata/path, no el archivo binario en la BD.

## 9. Student resource progress

Relación:

```text
student + resource
```

Campos conceptuales:

- student_id
- resource_id
- last_viewed_at
- completed_at
- timestamps

Solo una fila por estudiante/recurso.

## 10. Questions

Campos conceptuales:

- id
- competency_id
- created_by
- source_type
- type
- statement
- general_feedback
- status
- timestamps

`source_type`:

- PLATFORM
- TEACHER

`type`:

- MULTIPLE_CHOICE
- OPEN_TEXT

`status`:

- ACTIVE
- INACTIVE

Una pregunta pertenece a una única competencia.

## 11. Question options

Solo las preguntas MULTIPLE_CHOICE tienen opciones.

Reglas:

- exactamente 4 opciones;
- exactamente una correcta.

Las OPEN_TEXT no tienen opciones.

## 12. Evaluations

Una tabla central.

Tipos:

- DIAGNOSTIC
- COMPETENCY
- FINAL
- ASSIGNED

Campos conceptuales:

- id
- type
- competency_id nullable
- created_by nullable/según tipo
- title
- instructions
- duration_minutes
- max_attempts
- starts_at
- ends_at
- is_active
- timestamps

`COMPETENCY` se relaciona directamente con una competencia.

`ASSIGNED` requiere creador.

## 13. Evaluation question rules

Representa las reglas de selección.

Permite expresar:

- cantidad;
- competencia;
- tipo;
- fuente;
- restricciones de selección.

Esto evita codificar toda la estructura de 291 preguntas como lógica rígida.

## 14. Evaluation students

Representa la asignación de una evaluación a un estudiante.

El estado de esta tabla representa **estado de asignación**, no estado de intento.

Ejemplos:

- ASSIGNED
- IN_PROGRESS
- COMPLETED
- CANCELLED

Una evaluación asignada puede modificarse mientras ningún estudiante haya iniciado un intento.

Después del primer intento, la asignación queda congelada.

## 15. Assigned evaluation questions

Contiene preguntas exclusivas de una evaluación ASSIGNED.

No forman parte del banco general.

Deben pertenecer a la misma competencia de la evaluación asignada.

## 16. Assigned evaluation question options

Opciones snapshot/propias de las preguntas exclusivas.

No deben confundirse con `question_options`.

## 17. Attempts

Cada ejecución de un estudiante.

Estados:

- IN_PROGRESS
- SUBMITTED
- AUTO_SUBMITTED

Campos conceptuales:

- id
- evaluation_id
- student_id
- status
- started_at
- submitted_at
- duration/metadata necesaria
- resultado agregado materializado cuando corresponda
- timestamps

Solo un IN_PROGRESS por estudiante/evaluación.

## 18. Attempt questions

Representa las preguntas concretas utilizadas en un intento.

Cada fila debe apuntar exactamente a una de:

- `question_id`
- `assigned_evaluation_question_id`

Regla XOR:

```text
exactamente una de las dos referencias debe estar presente
```

Debe almacenar snapshots del enunciado y metadata histórica necesaria.

## 19. Attempt question options

Snapshot de las opciones presentadas.

Conserva:

- texto;
- orden;
- información necesaria para corrección histórica.

El orden queda congelado.

## 20. Attempt answers

Cada pregunta debe tener una respuesta.

Estados relevantes:

- UNANSWERED
- respuesta cerrada corregida
- respuesta abierta pendiente/calificada

Para cerradas, la respuesta debe referenciar la opción del snapshot de `attempt_question_options`.

Para abiertas, conserva el texto y estado de calificación.

## 21. Grading assignments

Relaciona un intento/pregunta abierta con su calificador.

Para DIAGNOSTIC/COMPETENCY/FINAL:

- docente activo autorizado por competencia;
- asignación aleatoria;
- asignación por estudiante/intent.

Para ASSIGNED:

- únicamente el docente creador.

## 22. Additional attempt requests

Estados:

- PENDING
- APPROVED
- REJECTED

Solo una solicitud PENDING por estudiante/evaluación.

La solicitud debe contener razón.

## 23. Additional attempts

Registra los intentos adicionales realmente concedidos.

No modifica `evaluations.max_attempts`.

Debe conservar:

- cantidad;
- disponibilidad;
- decisión;
- contexto necesario.

## 24. Notifications

Una tabla central.

Campos conceptuales:

- id
- user_id
- type
- data
- read_at
- timestamps

Retención: 30 días después de lectura.

## 25. Audit logs

Campos conceptuales:

- id
- user_id nullable
- action
- entity_type
- entity_id
- old_values opcional
- new_values opcional
- ip_address
- user_agent
- created_at

No almacenar secretos ni respuestas completas.

Append-only.

Retención: 1 año.

## 26. Relaciones principales

```text
roles 1 ─── N users

users N ─── N competencies
      mediante teacher_competencies

competencies 1 ─── N learning_topics
competencies 1 ─── N resources
competencies 1 ─── N questions

learning_topics 1 ─── N resources
users 1 ─── N resources
users N ─── N resources
      mediante student_resource_progress

questions 1 ─── N question_options

evaluations 1 ─── N evaluation_question_rules
evaluations 1 ─── N evaluation_students
evaluations 1 ─── N attempts

evaluations 1 ─── N assigned_evaluation_questions
assigned_evaluation_questions 1 ─── N assigned_evaluation_question_options

attempts 1 ─── N attempt_questions
attempt_questions 1 ─── N attempt_question_options
attempt_questions 1 ─── N attempt_answers

attempts / open answers ─── grading_assignments

users 1 ─── N notifications
users 1 ─── N audit_logs

additional_attempt_requests 1 ─── N additional_attempts
```

## 27. Integridad

No utilizar cascadas destructivas sobre historial académico.

Las eliminaciones físicas deben estar restringidas.

Las entidades históricas deben conservarse mediante estados o estrategias de preservación.

## 28. Selección de 291 preguntas

El sistema debe seleccionar al iniciar el intento y dentro de una operación transaccional.

Debe validar:

- cantidad total;
- distribución por competencia;
- tipo;
- fuente;
- disponibilidad;
- exclusiones.

Si no existe disponibilidad suficiente:

- no iniciar el intento;
- informar solicitado vs disponible;
- no sustituir silenciosamente.

## 29. Repetición

Diagnóstico vs final:

- excluir preguntas del diagnóstico cuando exista suficiente banco.

Competencias:

- evitar preguntas de intentos anteriores cuando exista suficiente banco.

Si el banco es insuficiente, puede haber reutilización.

## 30. Snapshots

El historial no debe depender del estado actual de:

- `questions`;
- `question_options`;
- configuraciones futuras de `evaluations`.

Los snapshots son obligatorios para reconstrucción histórica.
