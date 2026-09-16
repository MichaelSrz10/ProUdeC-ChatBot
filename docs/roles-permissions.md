# ProUdeC — Roles y permisos

## 1. Roles

Exactamente cuatro:

- ESTUDIANTE
- DOCENTE
- COORDINADOR
- SUPERADMIN

Existe un único SuperAdmin.

## 2. Matriz general

| Recurso/acción | Estudiante | Docente | Coordinador | SuperAdmin |
|---|---|---|---|---|
| Registro público | Sí | No | No | No |
| Gestionar docentes | No | No | Sí | Sí |
| Gestionar estudiantes | Propio perfil | No | Sí | Sí |
| Gestionar competencias | No | No | Según alcance | Sí |
| Asignar competencias a docentes | No | No | Sí | Sí |
| Consultar preguntas | Según uso | Sí | Sí | Sí |
| Crear preguntas | No | Sí | Sí | Sí |
| Modificar pregunta propia | No | Sí | Sí | Sí |
| Modificar pregunta ajena | No | No | Sí | Sí |
| Desactivar pregunta | No | Propias | Sí | Sí |
| Reactivar pregunta | No | No | Sí | Sí |
| Crear recursos | No | Sí | Sí | Sí |
| Modificar recursos propios | No | Sí | Sí | Sí |
| Modificar recursos ajenos | No | No | Sí | Sí |
| Crear temas | No | Sí | Sí | Sí |
| Gestionar temas | No | Autorizados | Sí | Sí |
| Crear evaluación | No | Sí | No | No |
| Modificar evaluación sin intentos | No | Creador | Sí | Sí |
| Desactivar evaluación | No | Según reglas | Sí | Sí |
| Crear evaluación institucional | No | No | No | Según definición |
| Tomar evaluaciones | Sí | No | No | No |
| Calificar abiertas asignadas | No | Según asignación | Sí, intervención | Sí |
| Solicitar intentos adicionales | Sí | No | No | No |
| Resolver solicitudes | No | No | Sí | Sí, intervención |
| Analítica propia | Sí | Sí | Sí | Sí |
| Analítica institucional | No | No | Sí | Sí |
| Exportar desempeño | Propio | Sus competencias | Institucional | Institucional |
| Consultar auditoría | No | No | Sí | Sí |

## 3. Estudiante

Puede:

- gestionar su perfil permitido;
- realizar diagnóstico;
- consultar recursos;
- completar recursos;
- realizar pruebas;
- consultar historial;
- realizar evaluaciones asignadas;
- solicitar intentos adicionales;
- consultar notificaciones;
- consultar sus calificaciones abiertas publicadas.

No puede acceder a información de otros estudiantes.

## 4. Docente

El alcance académico depende de `teacher_competencies`.

Puede gestionar:

- recursos propios;
- preguntas propias;
- temas dentro de competencias autorizadas;
- evaluaciones asignadas;
- calificaciones que le correspondan.

Puede consultar y utilizar preguntas de otros docentes dentro de competencias autorizadas, pero no modificarlas.

## 5. Coordinador

Tiene alcance institucional amplio.

Puede:

- administrar docentes;
- administrar estudiantes según reglas;
- asignar competencias;
- crear/modificar/desactivar preguntas;
- administrar recursos;
- administrar temas;
- administrar evaluaciones;
- resolver intentos adicionales;
- consultar y gestionar calificaciones;
- reasignar calificadores;
- consultar analítica;
- consultar auditoría.

El Coordinador no crea evaluaciones en el flujo normal de creación docente.

## 6. SuperAdmin

Tiene control administrativo total dentro de las restricciones del proyecto.

No puede existir un segundo SuperAdmin.

Puede intervenir sobre:

- usuarios;
- roles;
- competencias;
- preguntas;
- recursos;
- evaluaciones;
- calificaciones;
- analítica;
- auditoría.

## 7. Competencia docente

La autorización de un docente se determina mediante:

`teacher_competencies`

Perder una competencia no borra historial.

Las tareas pendientes de calificación pueden reasignarse.

## 8. Calificación

### ASSIGNED

Solo el docente creador puede calificar.

### DIAGNOSTIC / COMPETENCY / FINAL

El sistema asigna aleatoriamente un docente activo autorizado para la competencia.

Coordinador puede intervenir/reasignar.

SuperAdmin puede intervenir.

## 9. Reasignación

Cuando un docente pierde una competencia con tareas pendientes:

- buscar docente activo autorizado;
- reasignar;
- auditar;
- notificar al docente anterior;
- notificar al nuevo docente.

## 10. Principio

La autorización debe verificarse en backend.

Ocultar una opción de UI no constituye autorización.
