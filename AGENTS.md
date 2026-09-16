# AGENTS.md — Gobierno y reglas del agente ProUdeC

## 1. Propósito de este documento

Este documento define las reglas operativas, técnicas y arquitectónicas que todo agente de desarrollo debe seguir dentro del proyecto **ProUdeC**.

El agente debe leer este documento **antes de analizar, modificar, crear o eliminar cualquier archivo del proyecto**.

Este archivo funciona como un **contrato de trabajo del agente**.

El agente no debe asumir que puede cambiar una decisión porque considere que existe una tecnología más moderna, una arquitectura diferente o una implementación aparentemente más sencilla.

Cuando exista una decisión documentada, esta tiene prioridad sobre las preferencias técnicas del agente.

---

# 2. Identidad del proyecto

## 2.1 Nombre

**ProUdeC**

## 2.2 Contexto

ProUdeC es una plataforma web orientada al fortalecimiento de las competencias evaluadas en el examen de estado **Saber Pro**, dirigida a estudiantes del programa de **Ingeniería de Sistemas y Computación de la Universidad de Cundinamarca, Seccional Ubaté**.

## 2.3 Objetivo general

Desarrollar una plataforma web para el fortalecimiento de las competencias evaluadas en el examen de estado Saber Pro, dirigida a los estudiantes de Ingeniería de Sistemas y Computación de la Universidad de Cundinamarca, Seccional Ubaté.

## 2.4 Objetivos específicos

1. Determinar las falencias académicas y los requisitos funcionales de los estudiantes mediante el análisis de los componentes evaluados en las guías oficiales del ICFES Saber Pro.
2. Modelar la arquitectura del software, el diseño de la interfaz de usuario (UI/UX) y la estructura de la base de datos necesaria para la persistencia de los simulacros.
3. Codificar los módulos de la plataforma web utilizando tecnologías orientadas a entornos virtuales de aprendizaje y herramientas de seguimiento ágil.
4. Validar la evolución/cambio del desempeño de los estudiantes mediante pruebas piloto, incluyendo diagnóstico/pre-test y evaluación final/post-test.

---

# 3. Principio fundamental del agente

El agente debe comportarse como un **desarrollador profesional que trabaja bajo una arquitectura previamente definida**, no como un arquitecto autónomo con libertad para rediseñar el proyecto.

El agente debe:

* analizar antes de modificar;
* comprender antes de implementar;
* reutilizar antes de duplicar;
* validar antes de asumir;
* probar antes de declarar terminado;
* documentar decisiones relevantes;
* preservar la integridad histórica;
* respetar las reglas de negocio;
* detenerse cuando encuentre una ambigüedad arquitectónica o funcional.

---

# 4. Jerarquía de autoridad

Cuando existan conflictos entre información, aplicar el siguiente orden:

1. Requisitos y decisiones explícitas del propietario del proyecto.
2. `AGENTS.md`.
3. Documentación oficial de `/docs`.
4. Código existente que implemente correctamente una decisión documentada.
5. Convenciones oficiales de Laravel, PHP, MySQL y herramientas adoptadas.
6. Preferencias técnicas del agente.

El agente **no puede modificar una decisión de nivel superior para acomodarla a una preferencia técnica propia**.

Si encuentra una contradicción real entre documentos, código y requisitos, debe detener la implementación afectada y reportarla.

---

# 5. Regla de oro: no inventar requisitos

El agente NO debe inventar:

* funcionalidades;
* roles;
* permisos;
* tablas;
* campos;
* estados;
* reglas de negocio;
* flujos de usuario;
* fórmulas de puntuación;
* límites;
* comportamientos de interfaz;
* integraciones externas;
* dependencias;
* tecnologías;
* automatizaciones.

Si una decisión es necesaria para continuar y no está definida, el agente debe:

1. identificar la ambigüedad;
2. explicar por qué afecta la implementación;
3. presentar alternativas razonables;
4. recomendar una opción técnicamente justificada;
5. detener la parte afectada hasta recibir autorización.

No debe seleccionar silenciosamente una alternativa cuando esta pueda modificar requisitos, arquitectura, seguridad, datos o comportamiento funcional.

---

# 6. Tecnologías obligatorias

Las siguientes decisiones son obligatorias.

## Backend

* PHP
* Laravel 12
* Arquitectura MVC de Laravel

## Base de datos

* MySQL 8.4
* Motor InnoDB
* `utf8mb4`

**NO utilizar MariaDB como base de datos del proyecto.**

XAMPP puede estar instalado en el equipo, pero la base de datos de ProUdeC es **MySQL 8.4 independiente**.

## Frontend

* Laravel Blade
* CSS
* JavaScript
* Vite
* Tailwind CSS cuando sea apropiado dentro de la configuración existente

No utilizar React para ProUdeC salvo autorización explícita.

## Control de versiones

* Git
* GitHub

## Sistema operativo de desarrollo

* macOS

---

# 7. Principios de arquitectura

El proyecto debe priorizar:

* claridad;
* mantenibilidad;
* seguridad;
* separación de responsabilidades;
* cohesión;
* bajo acoplamiento;
* reutilización;
* testabilidad;
* trazabilidad;
* simplicidad razonable.

No se debe introducir complejidad arquitectónica únicamente por seguir tendencias.

## 7.1 Controladores

Los controladores deben ser delgados.

No colocar grandes cantidades de lógica de negocio directamente en los controladores.

Cuando una operación implique reglas complejas, transacciones, selección de preguntas, cálculo de intentos, asignación de calificadores u otras reglas de negocio, utilizar una separación apropiada mediante servicios/clases de dominio o mecanismos equivalentes compatibles con Laravel.

## 7.2 Modelos

Los modelos Eloquent deben representar correctamente sus relaciones y responsabilidades.

Evitar:

* consultas duplicadas;
* lógica repetida;
* relaciones inconsistentes;
* atributos ambiguos;
* acceso directo innecesario a la base de datos desde múltiples capas.

## 7.3 Vistas

Las vistas Blade deben mantenerse organizadas y reutilizables.

Evitar duplicación de HTML y lógica de presentación.

## 7.4 JavaScript

JavaScript debe utilizarse para interacción y comportamiento de interfaz.

La lógica crítica de seguridad y negocio **nunca debe depender exclusivamente del frontend**.

---

# 8. Arquitectura funcional general

El flujo principal de ProUdeC es:

```text
Registro
    ↓
Verificación del correo institucional
    ↓
Inicio de sesión
    ↓
Diagnóstico obligatorio / Pre-test
    ↓
Perfil inicial de desempeño
    ↓
8 competencias
    ↓
Recursos + pruebas
    ↓
Hasta 8 intentos automáticos por competencia
    ↓
≥ 70 % de respuestas cerradas correctas
    ↓
Competencia finalizada
    ↓
Todas las competencias finalizadas
    ↓
Simulación final / Post-test
    ↓
Comparación de evolución del desempeño
```

---

# 9. Roles del sistema

Existen exactamente cuatro roles estructurales:

1. `ESTUDIANTE`
2. `DOCENTE`
3. `COORDINADOR`
4. `SUPERADMIN`

Debe existir **un único SuperAdmin**.

No crear roles adicionales sin autorización.

---

# 10. Competencias

ProUdeC trabaja con exactamente ocho competencias:

1. Lectura Crítica
2. Razonamiento Cuantitativo
3. Competencias Ciudadanas
4. Comunicación Escrita
5. Inglés
6. Diseño de software
7. Formulación de proyectos de ingeniería
8. Pensamiento científico

Cada pregunta pertenece a **una sola competencia**.

Las competencias no tienen subcompetencias académicas adicionales dentro del modelo actual.

Los `learning_topics` son mecanismos de organización de recursos y **no representan subcompetencias académicas**.

---

# 11. Banco de preguntas

Existen dos fuentes generales:

* `PLATFORM`
* `TEACHER`

Las preguntas pueden ser:

* `MULTIPLE_CHOICE`
* `OPEN_TEXT`

## 11.1 Preguntas de selección múltiple

* exactamente 4 opciones;
* exactamente una opción correcta.

## 11.2 Preguntas abiertas

* tipo texto;
* máximo 5.000 caracteres;
* no poseen opciones;
* requieren calificación docente;
* estados de resultado:

  * `PENDING`
  * `INCORRECT`
  * `PARTIAL`
  * `CORRECT`

Las preguntas abiertas no afectan el porcentaje cuantitativo.

---

# 12. Historial de preguntas

Las preguntas pueden ser modificadas o desactivadas para futuras ejecuciones.

Sin embargo, las ejecuciones históricas deben conservar su información mediante snapshots.

Las tablas de intentos deben conservar:

* enunciado utilizado;
* opciones utilizadas;
* orden;
* información necesaria para reconstruir la experiencia histórica.

El `question_id` sirve para trazabilidad, pero la reconstrucción histórica no debe depender exclusivamente del estado actual de la pregunta.

No implementar versionamiento formal de preguntas salvo autorización.

---

# 13. Preguntas exclusivas de evaluaciones asignadas

Las preguntas exclusivas de una evaluación `ASSIGNED`:

* pertenecen únicamente a esa evaluación;
* no forman parte del banco general;
* no se utilizan en prácticas;
* no se utilizan en diagnóstico;
* no se utilizan en la evaluación final.

Su estructura se mantiene separada del banco general.

Una vez iniciada una evaluación asignada, sus condiciones deben quedar protegidas.

---

# 14. Evaluaciones

Existe una tabla central de evaluaciones.

Los tipos son exactamente:

* `DIAGNOSTIC`
* `COMPETENCY`
* `FINAL`
* `ASSIGNED`

---

# 15. Diagnóstico

El diagnóstico es obligatorio antes del acceso académico normal.

Es una evaluación global de las ocho competencias.

Debe contener exactamente:

**291 preguntas**

* 290 cerradas;
* 1 abierta.

Distribución:

| Competencia                            |                     Cerradas |
| -------------------------------------- | ---------------------------: |
| Lectura Crítica                        |                           35 |
| Razonamiento Cuantitativo              |                           35 |
| Competencias Ciudadanas                |                           35 |
| Inglés                                 |                           55 |
| Comunicación Escrita                   |       0 cerradas + 1 abierta |
| Diseño de software                     |                           40 |
| Formulación de proyectos de ingeniería |                           40 |
| Pensamiento científico                 |                           50 |
| **Total**                              | **290 cerradas + 1 abierta** |

La selección se realiza al iniciar el intento.

Una vez iniciado:

* preguntas congeladas;
* opciones congeladas;
* orden congelado;
* condiciones congeladas.

El diagnóstico se realiza una sola vez.

---

# 16. Evaluaciones por competencia

Cada competencia posee una prueba principal de:

**20 preguntas**

La selección es aleatoria.

Debe evitarse repetir exactamente las mismas preguntas entre intentos cuando exista suficiente banco disponible.

Si no existe suficiente banco, puede reutilizarse una pregunta.

La regla de disponibilidad debe validarse antes de iniciar el intento.

Nunca realizar sustituciones silenciosas.

---

# 17. Intentos de competencias

Cada estudiante dispone inicialmente de:

**8 intentos automáticos por competencia.**

Una competencia se considera académicamente finalizada cuando el estudiante obtiene:

**≥ 70 % de respuestas cerradas correctas en cualquier intento.**

Las preguntas abiertas no participan en este porcentaje.

Todos los intentos históricos se conservan.

Finalizar una competencia **no bloquea** al estudiante para seguir practicando.

---

# 18. Intentos adicionales

Si el estudiante agota los intentos permitidos sin finalizar la competencia:

1. puede solicitar intentos adicionales;
2. debe proporcionar una razón;
3. solo puede existir una solicitud `PENDING` por estudiante/evaluación;
4. el Coordinador puede aprobar o rechazar;
5. el Coordinador puede conceder menos intentos que los solicitados;
6. nunca puede conceder más que los solicitados;
7. puede configurar disponibilidad inmediata o futura;
8. la decisión debe quedar auditada;
9. el estudiante recibe una notificación interna.

Los intentos adicionales se almacenan separadamente.

No modificar `evaluations.max_attempts` para representar intentos adicionales.

---

# 19. Evaluación final

La evaluación final se habilita cuando las ocho competencias hayan sido finalizadas.

Contiene exactamente:

**291 preguntas**

* 290 cerradas;
* 1 abierta.

Debe mantener la misma distribución por competencia del diagnóstico.

Siempre que exista suficiente banco disponible, debe evitar las preguntas utilizadas previamente en el diagnóstico.

La evaluación final dispone de:

**3 intentos automáticos.**

Los intentos adicionales requieren solicitud al Coordinador.

La evaluación final permite analizar la evolución entre diagnóstico y resultado final.

No afirmar que el porcentaje interno de ProUdeC equivale directamente al puntaje oficial del ICFES.

---

# 20. Cálculo cuantitativo

La métrica cuantitativa de ProUdeC se define como:

```text
porcentaje =
respuestas cerradas correctas
/
total de preguntas cerradas
× 100
```

Las preguntas cerradas sin responder cuentan como incorrectas para el denominador.

Las preguntas abiertas no afectan este porcentaje.

No inventar equivalencias con escalas oficiales del ICFES.

---

# 21. Reglas de inicio de intento

Antes de comenzar una evaluación se debe mostrar una pantalla de instrucciones que indique, como mínimo:

* número de preguntas;
* tiempo;
* número de intentos;
* instrucciones;
* advertencias relevantes;
* botón para comenzar.

Al iniciar:

1. se crea el intento;
2. se seleccionan las preguntas;
3. se generan snapshots;
4. se congela el orden;
5. se congela el orden de opciones;
6. se establecen las condiciones del intento.

No modificar las condiciones de un intento ya iniciado.

---

# 22. Estado de los intentos

Los intentos utilizan:

* `IN_PROGRESS`
* `SUBMITTED`
* `AUTO_SUBMITTED`

Cerrar el navegador no abandona el intento.

El estudiante puede regresar mientras el tiempo siga vigente.

El backend es la autoridad sobre el tiempo.

El temporizador frontend solamente representa el tiempo restante.

Al llegar a cero, el backend debe realizar el envío automático.

---

# 23. Un intento activo

Debe existir como máximo:

**un intento `IN_PROGRESS` por estudiante y evaluación.**

La protección debe existir a nivel de servicio/transacción y, cuando sea apropiado, mediante restricciones de base de datos compatibles con MySQL.

No confiar únicamente en validaciones JavaScript.

---

# 24. Respuestas

Cada pregunta del intento tiene un registro de respuesta.

Una pregunta sin responder debe representar explícitamente el estado:

`UNANSWERED`

Las respuestas cerradas deben conservar:

* opción seleccionada;
* referencia a la opción snapshot;
* resultado de corrección.

Las respuestas abiertas deben conservar:

* texto del estudiante;
* estado de calificación;
* calificador;
* fechas;
* retroalimentación.

---

# 25. Calificación de preguntas abiertas

La calificación de preguntas abiertas es independiente de la puntuación cuantitativa.

Resultados:

* Incorrecta
* Parcialmente correcta
* Correcta

El docente puede agregar retroalimentación.

El docente puede guardar un borrador.

El borrador:

* persiste;
* no es visible al estudiante.

Solo al finalizar/publicar la calificación:

* se hace visible al estudiante;
* se considera finalizada.

Cada respuesta abierta puede calificarse independientemente.

---

# 26. Asignación de calificadores

Para:

### ASSIGNED

Solo puede calificar:

**el docente que creó la evaluación asignada.**

No debe utilizarse como criterio suficiente que otro docente tenga autorización sobre la competencia.

### DIAGNOSTIC / COMPETENCY / FINAL

Cuando exista una pregunta abierta que requiera calificación:

* el sistema asigna aleatoriamente un docente activo autorizado para la competencia;
* la asignación ocurre al finalizar/enviar el intento;
* la asignación se conserva;
* la asignación es por estudiante/intento, no por evaluación completa.

Si no existe docente autorizado:

* no bloquear al estudiante;
* mantener pendiente;
* permitir que el Coordinador resuelva posteriormente.

---

# 27. Permisos de docentes

Un docente solo puede gestionar las competencias que le hayan sido asignadas.

El docente puede:

* consultar desempeño dentro de sus competencias;
* crear recursos;
* modificar sus propios recursos;
* eliminar/desactivar sus propios recursos;
* crear preguntas;
* modificar/desactivar sus propias preguntas;
* consultar/utilizar preguntas de otros docentes cuando tenga autorización sobre la competencia;
* crear evaluaciones;
* modificar una evaluación mientras ningún estudiante haya iniciado un intento;
* gestionar calificaciones que le hayan sido asignadas.

El Coordinador y SuperAdmin tienen capacidades administrativas superiores según las reglas documentadas.

---

# 28. Preguntas creadas por docentes

Una pregunta de tipo `TEACHER`:

* pertenece a un creador;
* queda activa inmediatamente;
* no requiere aprobación institucional;
* puede ser utilizada dentro de las competencias autorizadas;
* puede ser administrada por su creador;
* puede ser modificada/desactivada administrativamente por Coordinador o SuperAdmin.

Cuando el Coordinador modifica una pregunta creada por un docente, debe generarse una notificación interna al docente.

---

# 29. Recursos educativos

Tipos:

* PDF
* PPT
* PPTX
* imágenes
* videos
* enlaces externos

Los archivos físicos no deben almacenarse dentro de la base de datos.

La base de datos conserva:

* metadata;
* ubicación/path;
* tipo;
* creador;
* estado;
* información necesaria para acceder al recurso.

---

# 30. Organización de recursos

Cada recurso pertenece a una competencia.

Los recursos pueden pertenecer a un `learning_topic`.

Si no se especifica un tema:

**se asignan automáticamente al tema “Recursos Adicionales”.**

Cada competencia tiene su propio “Recursos Adicionales”.

Este tema:

* no puede eliminarse;
* siempre existe;
* aparece al final de la lista de temas.

Los recursos tienen orden configurable.

---

# 31. Progreso de recursos

El estudiante debe realizar una acción explícita para marcar un recurso como completado.

Abrir un recurso:

* registra `last_viewed_at`;
* no significa que esté completado.

Marcar como completado:

* establece `completed_at`.

Reabrir un recurso:

* actualiza consulta;
* no incrementa nuevamente el progreso.

Cada recurso cuenta una sola vez.

---

# 32. Progreso visual de competencia

El progreso visual de la competencia es independiente del desempeño académico.

La barra se estructura así:

* recursos: 90 %;
* prueba: 10 %.

La prueba completa ese 10 % cuando ha sido presentada, independientemente de su porcentaje obtenido.

Ejemplo:

```text
Recursos completos: 100 %
Prueba presentada: sí

Progreso visual: 100 %
Resultado académico: 65 %
Estado: EN PROGRESO
```

Si el estudiante obtiene ≥70 % en una prueba de competencia:

```text
Estado académico: FINALIZADA
Progreso visual: 100 %
```

No utilizar la barra visual como sustituto del porcentaje académico.

---

# 33. Desactivación

No utilizar eliminación física indiscriminada para información académica.

Las preguntas utilizan:

* `ACTIVE`
* `INACTIVE`

Los recursos y evaluaciones utilizan estados/indicadores de actividad apropiados.

Una desactivación debe preservar el historial.

No destruir:

* intentos;
* respuestas;
* snapshots;
* calificaciones;
* trazabilidad histórica.

---

# 34. Integridad histórica

Este es un principio crítico.

**Nunca modificar datos históricos de manera que una ejecución anterior pueda cambiar retrospectivamente.**

Ejemplo:

Si una pregunta cambia hoy, un intento realizado ayer debe seguir mostrando la versión que el estudiante respondió ayer.

Si una evaluación se desactiva hoy, los intentos históricos deben permanecer.

Si un recurso se desactiva, sus registros históricos de consulta/completitud pueden conservarse.

---

# 35. Usuarios

Los estudiantes utilizan registro público.

Docentes, Coordinadores y SuperAdmin son administrados por usuarios autorizados.

El correo institucional del estudiante debe terminar exactamente en:

`@ucundinamarca.edu.co`

Debe verificarse la propiedad del correo antes del acceso académico.

El correo debe ser único incluso si la cuenta está inactiva.

---

# 36. Seguridad de contraseñas

Nunca almacenar contraseñas en texto plano.

Utilizar el mecanismo seguro de hashing proporcionado por Laravel, configurado con **Argon2id** según la decisión de seguridad del proyecto.

Nunca registrar en logs:

* contraseñas;
* tokens;
* secretos;
* credenciales.

---

# 37. Autenticación

Debe existir:

* verificación de correo institucional;
* recuperación de contraseña;
* invalidación de sesiones activas al cambiar contraseña;
* posibilidad de múltiples sesiones simultáneas;
* protección contra intentos de inicio de sesión abusivos.

Regla de rate limiting:

**máximo 10 intentos de login en una ventana de 30 segundos**, con limitación temporal posterior.

Utilizar mecanismos de Laravel siempre que sean adecuados.

---

# 38. Autorización

La seguridad debe implementarse en backend.

Utilizar:

* Middleware;
* Policies;
* Gates cuando corresponda;
* validación de propiedad;
* validación de competencia autorizada;
* validación de rol.

Nunca confiar en:

* botones ocultos;
* JavaScript;
* URLs no visibles;
* campos enviados desde el navegador.

Que un usuario no vea un botón no significa que tenga permiso para realizar la operación.

---

# 39. Protección CSRF

Utilizar la protección CSRF estándar de Laravel.

No desactivarla globalmente.

No implementar mecanismos paralelos sin justificación y autorización.

---

# 40. Archivos subidos

Todo archivo debe validarse mediante:

* extensión permitida;
* MIME permitido;
* tamaño;
* ubicación segura;
* nombre físico generado por el sistema.

El usuario puede proporcionar un nombre visible para el recurso.

El nombre físico debe ser generado de manera segura por el sistema.

Límites actuales:

| Tipo                |            Máximo |
| ------------------- | ----------------: |
| Video propio        |            500 MB |
| PDF/PPT/PPTX/imagen |             20 MB |
| Video externo       | sin archivo local |

---

# 41. Auditoría

Debe existir un sistema central de auditoría append-only.

Tabla:

`audit_logs`

Debe registrar, entre otros:

* autenticación exitosa;
* autenticación fallida;
* logout;
* cambios de roles;
* administración de usuarios;
* creación/modificación/desactivación de preguntas;
* cambios de recursos;
* cambios de evaluaciones;
* asignaciones;
* inicio de intentos;
* envío manual;
* envío automático;
* decisiones sobre intentos adicionales;
* finalización/publicación de calificaciones;
* reasignaciones de calificación.

No registrar:

* contraseñas;
* tokens;
* secretos;
* respuestas completas del estudiante.

El usuario responsable puede ser `NULL` para acciones automáticas del sistema.

La auditoría es:

**append-only**

No debe existir una interfaz normal para modificar o eliminar registros.

Retención definida:

**1 año.**

---

# 42. Notificaciones

Las notificaciones son exclusivamente internas de ProUdeC.

No enviar notificaciones por correo como mecanismo normal.

Se utiliza una tabla central `notifications`.

Las notificaciones deben permitir:

* no leída;
* leída;
* `read_at`.

Retención:

**30 días después de haber sido leídas.**

Tipos relevantes:

* `EXTRA_ATTEMPT_REQUEST`
* `EXTRA_ATTEMPT_DECISION`
* `GRADING_ASSIGNED`
* `GRADING_REASSIGNED`
* `QUESTION_MODIFIED`

---

# 43. Cambios de competencias docentes

Un docente puede tener múltiples competencias autorizadas.

La relación es:

```text
teacher_competencies
```

Si se elimina una competencia del docente:

* no borrar su historial;
* no romper evaluaciones anteriores;
* no perder trazabilidad.

Si existen tareas de calificación pendientes, deben reasignarse a otro docente activo autorizado cuando corresponda.

La reasignación debe auditarse.

El docente anterior y el nuevo docente deben recibir notificación interna.

---

# 44. Evaluaciones asignadas

Las evaluaciones `ASSIGNED`:

* tienen creador;
* tienen estudiantes asignados;
* son independientes del progreso de competencias;
* no finalizan competencias;
* no modifican barras de progreso de competencias.

Mientras ningún estudiante haya iniciado un intento:

* pueden modificarse los estudiantes asignados.

Después del primer intento:

* la asignación queda congelada.

---

# 45. Desactivación de evaluaciones

Cuando una evaluación asignada se desactiva:

### Estudiante asignado sin iniciar

Pasa a:

`CANCELLED`

### Estudiante con intento iniciado

Puede terminar su intento.

No destruir el historial.

---

# 46. SuperAdmin

Debe existir exactamente un SuperAdmin.

El SuperAdmin tiene control administrativo total dentro de los límites del modelo del proyecto.

Puede:

* administrar usuarios;
* modificar roles según reglas;
* administrar competencias;
* administrar evaluaciones;
* administrar preguntas;
* administrar recursos;
* acceder a analítica;
* intervenir administrativamente cuando corresponda.

No permitir crear/promover un segundo SuperAdmin.

Los roles no deben ser eliminables desde la interfaz.

---

# 47. Cambio de roles

Los cambios de rol deben estar restringidos.

No permitir conversiones arbitrarias entre estudiante y personal administrativo.

El agente debe respetar las reglas específicas de SuperAdmin antes de implementar cualquier operación de cambio de rol.

Si una operación no está suficientemente definida, detenerse y solicitar decisión.

---

# 48. Eliminación de usuarios

La integridad académica tiene prioridad sobre la eliminación física.

No realizar eliminación física de usuarios cuando pueda destruir:

* intentos;
* respuestas;
* calificaciones;
* auditoría;
* asignaciones;
* trazabilidad.

En estos casos utilizar desactivación o mecanismos de preservación definidos en la arquitectura.

---

# 49. Inactividad de estudiantes

Los estudiantes no verificados pueden ser desactivados automáticamente después de:

**3 horas**

de acuerdo con la regla definida.

Los estudiantes pueden ser desactivados por inactividad después de:

**120 días**

La reactivación de estudiantes se realiza mediante verificación del correo institucional.

---

# 50. Base de datos

La arquitectura física actual contempla las siguientes entidades principales:

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

No agregar tablas por conveniencia sin justificar su necesidad.

No eliminar tablas arquitectónicas sin revisar primero `/docs/database.md`.

---

# 51. Migraciones

Toda modificación estructural de la base de datos debe realizarse mediante migraciones de Laravel.

Nunca modificar manualmente la estructura de producción/desarrollo como sustituto de una migración.

Las migraciones deben:

* tener nombres claros;
* respetar dependencias;
* definir índices apropiados;
* definir claves foráneas;
* utilizar tipos consistentes;
* evitar cascadas destructivas sobre información académica.

---

# 52. Transacciones

Utilizar transacciones cuando una operación afecte varias entidades y deba ser atómica.

Especialmente:

* inicio de intento;
* selección de preguntas;
* creación de snapshots;
* asignación de preguntas;
* generación de intentos adicionales;
* decisiones que involucren múltiples registros relacionados;
* operaciones críticas de permisos.

---

# 53. Concurrencia

El agente debe considerar concurrencia en operaciones críticas.

Casos especialmente sensibles:

* inicio simultáneo de intentos;
* límite de intentos;
* solicitudes adicionales;
* asignaciones;
* selección de preguntas;
* modificación/desactivación mientras se inicia una evaluación.

No solucionar problemas de concurrencia únicamente con validación frontend.

---

# 54. Regla de congelamiento de intentos

Cuando un estudiante inicia un intento:

**las condiciones de ese intento quedan congeladas.**

Esto incluye, según corresponda:

* preguntas;
* opciones;
* orden;
* contenido;
* duración;
* reglas;
* condiciones de selección;
* permisos necesarios para iniciar.

Si posteriormente cambia una configuración administrativa, un intento `IN_PROGRESS` no debe romperse.

---

# 55. Analítica

La fuente principal de verdad para el desempeño es:

```text
attempts
    ↓
attempt_questions
    ↓
attempt_answers
```

Las métricas derivadas pueden materializarse si existe una razón técnica, pero no deben convertirse en una fuente histórica contradictoria.

El estudiante puede consultar:

* diagnóstico;
* intentos;
* resultados;
* desempeño por competencia;
* progreso;
* preguntas correctas/incorrectas;
* evolución diagnóstico vs final;
* evaluaciones asignadas.

---

# 56. Analítica por roles

## Estudiante

Solo sus propios datos.

## Docente

Datos correspondientes a sus competencias autorizadas.

## Coordinador

Acceso institucional amplio.

## SuperAdmin

Acceso institucional completo.

Nunca devolver datos de otro usuario simplemente porque una ruta sea accesible.

---

# 57. Exportaciones

Los reportes deben soportar:

* CSV;
* Excel.

No implementar PDF como obligación arquitectónica salvo que exista una necesidad documentada.

---

# 58. UX/UI

La interfaz debe ser:

* responsive;
* clara;
* consistente;
* accesible;
* usable;
* orientada a tareas;
* visualmente profesional.

No introducir un framework frontend diferente únicamente por razones estéticas.

Blade + CSS + JavaScript es suficiente para el alcance actual.

---

# 59. Principios de frontend

Debe priorizarse:

* componentes reutilizables;
* layouts consistentes;
* estados claros;
* mensajes de error útiles;
* validaciones accesibles;
* feedback visual;
* navegación coherente.

Los elementos visuales nunca deben sustituir las validaciones del backend.

---

# 60. Pruebas

Toda funcionalidad relevante debe tener pruebas.

Como mínimo se deben considerar:

* pruebas unitarias;
* pruebas de integración;
* pruebas de funcionalidades;
* autorización;
* validación;
* casos límite;
* concurrencia cuando aplique.

Especial atención a:

* permisos por rol;
* permisos por competencia;
* límites de intentos;
* selección de preguntas;
* exclusión/reutilización;
* preguntas abiertas;
* auto-submit;
* congelamiento de intentos;
* solicitudes adicionales;
* integridad histórica.

---

# 61. Casos de prueba obligatorios

Antes de considerar terminada una implementación relacionada con evaluaciones, comprobar como mínimo:

### Intentos

* inicio correcto;
* segundo intento simultáneo bloqueado;
* cierre del navegador;
* reanudación;
* envío manual;
* auto-submit;
* intento con preguntas sin responder.

### Preguntas

* exactamente cuatro opciones;
* una correcta;
* pregunta abierta sin opciones;
* máximo de caracteres;
* pregunta desactivada no seleccionable.

### Selección

* distribución correcta;
* fuente correcta;
* competencia correcta;
* cantidad correcta;
* comportamiento cuando no hay suficientes preguntas.

### Historial

* modificación posterior de pregunta no altera intento histórico;
* desactivación no elimina historial;
* cambio administrativo no rompe intento activo.

### Permisos

Probar cada operación sensible con:

* usuario autorizado;
* usuario no autorizado;
* usuario de otro rol;
* docente con otra competencia;
* estudiante intentando acceso administrativo.

---

# 62. Calidad de código

No aceptar como solución:

* código duplicado innecesariamente;
* métodos gigantes;
* controladores con lógica excesiva;
* consultas SQL dispersas sin necesidad;
* nombres ambiguos;
* comentarios que oculten código incorrecto;
* funciones que hagan demasiadas cosas;
* validaciones únicamente en frontend;
* lógica de seguridad únicamente en frontend.

Preferir código explícito y mantenible sobre abstracciones excesivas.

---

# 63. Dependencias

No instalar paquetes nuevos automáticamente.

Antes de agregar una dependencia:

1. verificar si Laravel o PHP ya resuelven el problema;
2. verificar si el proyecto ya tiene una dependencia equivalente;
3. evaluar mantenimiento;
4. evaluar seguridad;
5. evaluar impacto arquitectónico;
6. documentar la razón.

Si la dependencia afecta arquitectura o mantenimiento, solicitar autorización antes de instalarla.

---

# 64. No sobreingeniería

No implementar:

* microservicios;
* CQRS;
* event sourcing;
* repositorios innecesarios;
* patrones excesivos;
* sistemas de colas complejos;
* infraestructura innecesaria;
* APIs separadas;
* frontend SPA independiente;

salvo que exista una necesidad real y autorización.

La solución debe ser apropiada para el alcance de ProUdeC.

---

# 65. Código existente

Antes de reemplazar código existente:

1. leerlo;
2. comprender su propósito;
3. comprobar si ya satisface una necesidad;
4. evaluar impacto;
5. conservar lo reutilizable.

No eliminar archivos simplemente porque el agente prefiere otra implementación.

---

# 66. Archivos sensibles

Nunca exponer ni versionar:

* `.env`;
* contraseñas;
* tokens;
* claves privadas;
* credenciales;
* archivos secretos;
* información sensible de usuarios.

No modificar `.gitignore` para permitir accidentalmente secretos.

---

# 67. Git

El agente debe mantener commits pequeños y coherentes.

No mezclar en un mismo commit:

* nueva funcionalidad;
* refactorizaciones no relacionadas;
* cambios de formato masivos;
* modificaciones accidentales.

Antes de un commit:

1. ejecutar pruebas relevantes;
2. revisar cambios;
3. verificar archivos modificados;
4. comprobar que no existan secretos;
5. confirmar que el cambio corresponde a la tarea.

No hacer `git reset --hard`, `git clean -fd` u operaciones destructivas sin autorización explícita.

---

# 68. Formato de trabajo obligatorio

Para cada tarea relevante:

```text
1. Leer documentación
2. Inspeccionar código existente
3. Identificar dependencias
4. Identificar decisiones aplicables
5. Analizar impacto
6. Crear plan
7. Implementar
8. Ejecutar pruebas
9. Ejecutar lint/formateo cuando corresponda
10. Revisar cambios
11. Corregir problemas
12. Ejecutar pruebas nuevamente
13. Documentar resultado
```

---

# 69. Modo de reconocimiento

Cuando se indique al agente que debe **analizar, auditar, reconocer o inspeccionar**:

NO debe modificar archivos.

Debe producir un informe que incluya:

* estructura del proyecto;
* tecnologías detectadas;
* estado actual;
* archivos relevantes;
* funcionalidades existentes;
* migraciones existentes;
* dependencias;
* inconsistencias;
* riesgos;
* posibles conflictos con la arquitectura;
* recomendaciones.

No debe “arreglar” automáticamente lo que encuentre durante una auditoría.

---

# 70. Modo de implementación

El agente solo debe implementar cuando la tarea esté autorizada.

Antes de modificar:

```text
REQUISITO
    ↓
DOCUMENTACIÓN
    ↓
ARQUITECTURA
    ↓
PLAN
    ↓
IMPLEMENTACIÓN
    ↓
PRUEBAS
```

Si durante la implementación aparece una decisión no documentada que afecta arquitectura, seguridad o reglas de negocio:

**DETENERSE.**

---

# 71. Cuándo el agente debe detenerse

El agente debe detenerse y solicitar decisión cuando encuentre:

* conflicto entre requisitos;
* conflicto entre documentos;
* conflicto entre código y requisitos;
* cambio de arquitectura;
* cambio de tecnología;
* nueva dependencia significativa;
* modificación de una regla de negocio;
* modificación del modelo de datos fundamental;
* comportamiento de seguridad no definido;
* ambigüedad sobre permisos;
* ambigüedad sobre datos históricos;
* ambigüedad sobre puntuación;
* ambigüedad sobre flujo académico;
* riesgo de pérdida de datos;
* necesidad de eliminar información histórica.

No debe resolver estos problemas silenciosamente.

---

# 72. Decisiones documentadas

Las decisiones del proyecto deben registrarse en:

```text
/docs/decisions.md
```

Cada decisión relevante debe poder responder:

* qué se decidió;
* por qué;
* qué alternativas fueron consideradas;
* qué impacto tiene;
* qué partes del sistema afecta.

Si una nueva decisión contradice una anterior, no sobrescribir silenciosamente la decisión antigua.

Registrar el cambio.

---

# 73. Documentación obligatoria

Antes de una implementación importante, revisar:

```text
/docs/requirements.md
/docs/architecture.md
/docs/database.md
/docs/security.md
/docs/roles-permissions.md
/docs/ui-ux.md
/docs/testing.md
/docs/decisions.md
```

Si alguno no existe todavía, el agente debe reportarlo durante la fase de reconocimiento.

No debe inventar su contenido sin autorización.

---

# 74. Reglas sobre base de datos

Antes de ejecutar migraciones:

* revisar todas las migraciones;
* comprobar orden de dependencias;
* comprobar claves foráneas;
* comprobar índices;
* comprobar nullable/non-nullable;
* comprobar estados;
* comprobar integridad histórica;
* comprobar nombres;
* comprobar tipos.

No ejecutar una migración destructiva sin autorización.

Especial cuidado con:

```text
DROP
TRUNCATE
DELETE masivo
DROP COLUMN
DROP TABLE
```

---

# 75. Reglas sobre datos históricos

Las entidades académicas históricas tienen prioridad de preservación.

No eliminar automáticamente registros relacionados con:

* intentos;
* respuestas;
* evaluaciones realizadas;
* calificaciones;
* auditorías;
* snapshots.

Si una operación administrativa requiere desactivar una entidad, preferir mecanismos no destructivos.

---

# 76. Regla sobre la puntuación

Nunca introducir una fórmula para convertir resultados internos de ProUdeC a puntajes oficiales Saber Pro sin una fuente y decisión explícita.

ProUdeC utiliza sus propias métricas internas de porcentaje para seguimiento y comparación.

Debe distinguirse siempre entre:

```text
Resultado interno de ProUdeC
```

y

```text
Puntaje oficial ICFES Saber Pro
```

---

# 77. Regla sobre contenido ICFES

El contenido de la plataforma debe respetar las fuentes y condiciones de uso definidas por el proyecto.

No asumir que cualquier material encontrado en internet puede ser copiado o incorporado.

Cuando exista duda sobre derechos de uso, licencia o procedencia:

**detenerse y solicitar revisión.**

---

# 78. Regla sobre IA

ProUdeC **no incorpora inteligencia artificial como funcionalidad del producto**.

El hecho de que el desarrollo sea realizado con asistencia de agentes de IA no significa que ProUdeC tenga una funcionalidad de IA.

No agregar:

* chatbot;
* generación automática de preguntas;
* recomendaciones generadas por IA;
* calificación automática mediante IA;
* asistentes inteligentes;

sin una decisión explícita del propietario del proyecto.

---

# 79. Regla sobre alcance

El agente no debe ampliar el alcance de ProUdeC por iniciativa propia.

No implementar como parte del alcance actual:

* gamificación;
* aplicaciones móviles nativas;
* IA;
* integraciones externas no definidas;
* sistemas multiorganización;
* soporte institucional para múltiples universidades;
* arquitectura distribuida;
* funcionalidades comerciales;
* funcionalidades sociales no requeridas.

---

# 80. Principio de trazabilidad

Toda operación académica importante debe poder rastrearse.

Debe ser posible responder:

* quién realizó la acción;
* sobre qué entidad;
* cuándo ocurrió;
* qué intento corresponde;
* qué estudiante corresponde;
* qué docente corresponde cuando aplique;
* qué evaluación corresponde.

La trazabilidad no debe depender exclusivamente de logs de aplicación informales.

---

# 81. Regla de nombres

Utilizar nombres claros y consistentes.

Preferir nombres semánticos como:

```text
competencies
learning_topics
resources
evaluations
attempts
attempt_questions
attempt_answers
```

Evitar abreviaturas innecesarias.

Los estados deben ser consistentes entre código y documentación.

---

# 82. Regla de errores

Los errores mostrados al usuario deben:

* ser comprensibles;
* no revelar información sensible;
* indicar qué puede hacer el usuario;
* mantener coherencia visual.

Los errores técnicos completos deben permanecer en logs apropiados, no mostrarse al usuario final en producción.

---

# 83. Regla de validación

Toda entrada controlada por el usuario debe validarse en backend.

Esto incluye:

* formularios;
* parámetros de URL;
* identificadores;
* cantidades;
* fechas;
* archivos;
* textos;
* respuestas;
* permisos.

Nunca asumir que los datos enviados desde el navegador son confiables.

---

# 84. Regla de consultas

Evitar:

* N+1 queries;
* consultas duplicadas;
* consultas innecesariamente grandes;
* cargar relaciones masivas sin necesidad.

Utilizar eager loading y paginación cuando corresponda.

No optimizar prematuramente sin evidencia.

---

# 85. Regla de rendimiento

Primero:

* corrección;
* seguridad;
* mantenibilidad.

Después:

* optimización.

Cuando se detecte un problema de rendimiento, medir antes de introducir una optimización compleja.

---

# 86. Regla de pruebas antes de terminar

El agente nunca debe afirmar:

> “La funcionalidad está terminada”

si no ha comprobado las pruebas correspondientes.

Debe indicar:

```text
Pruebas ejecutadas:
- ...
Resultado:
- ...
```

Si una prueba falla, debe reportarlo.

No ocultar fallos.

---

# 87. Informe final de cada tarea

Al terminar una tarea, el agente debe proporcionar:

## Resumen

Qué se implementó.

## Archivos modificados

Lista concreta.

## Base de datos

Migraciones creadas/modificadas.

## Seguridad

Cambios de autorización/validación relevantes.

## Pruebas

Pruebas ejecutadas y resultado.

## Decisiones

Decisiones nuevas o decisiones que debieron respetarse.

## Pendientes

Problemas o tareas que quedaron pendientes.

## Riesgos

Cualquier riesgo detectado.

---

# 88. Regla de honestidad técnica

El agente nunca debe afirmar que:

* ejecutó algo que no ejecutó;
* probó algo que no probó;
* verificó algo que no verificó;
* leyó un archivo que no leyó;
* corrigió un problema que no corrigió;
* una funcionalidad funciona si no fue comprobada.

Debe distinguir entre:

```text
Implementado
```

```text
Probado
```

```text
No probado
```

```text
Pendiente
```

---

# 89. Prioridad de calidad

Ante un conflicto entre:

* velocidad;
* simplicidad;
* calidad;
* seguridad;
* integridad histórica;

la prioridad es:

```text
1. Seguridad
2. Integridad de datos
3. Correctitud funcional
4. Arquitectura/mantenibilidad
5. Testabilidad
6. UX
7. Rendimiento
8. Velocidad de implementación
```

La velocidad nunca justifica romper una regla crítica.

---

# 90. Regla final

El agente está autorizado a **implementar**, pero no a **cambiar unilateralmente la definición del proyecto**.

Su responsabilidad es convertir decisiones documentadas en software de calidad.

Cuando exista claridad:

```text
Analizar → Planificar → Implementar → Probar → Revisar
```

Cuando exista ambigüedad crítica:

```text
Analizar → Identificar conflicto → Proponer alternativas → DETENERSE → Esperar decisión
```

Nunca:

```text
No sé qué hacer → Inventar una solución → Implementar
```

---

# 91. Estado actual del proyecto

Al iniciar una nueva tarea, el agente debe consultar el estado real del repositorio.

No asumir que las funcionalidades descritas en esta documentación ya están implementadas.

Debe distinguir entre:

```text
REQUERIDO
```

```text
DISEÑADO
```

```text
DOCUMENTADO
```

```text
IMPLEMENTADO
```

```text
PROBADO
```

Estas categorías no son equivalentes.

---

# 92. Primera instrucción para cualquier nuevo agente

Si este repositorio acaba de ser entregado al agente y todavía no existe una tarea concreta de implementación:

**NO MODIFICAR EL PROYECTO.**

Primero:

1. leer `AGENTS.md`;
2. leer `/docs`;
3. inspeccionar estructura del repositorio;
4. inspeccionar `composer.json`;
5. inspeccionar `package.json`;
6. inspeccionar `.env.example`;
7. inspeccionar `routes/`;
8. inspeccionar `app/`;
9. inspeccionar `database/`;
10. inspeccionar `resources/`;
11. revisar migraciones existentes;
12. revisar configuración relevante;
13. identificar estado de Git;
14. identificar inconsistencias;
15. generar un informe de reconocimiento.

La primera misión del agente debe ser **comprender ProUdeC antes de programar ProUdeC**.

---

# FIN DE AGENTS.md
