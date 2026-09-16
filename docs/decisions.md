# ProUdeC — Registro de decisiones arquitectónicas

Este documento consolida decisiones aprobadas del proyecto.

## ADR-001 — Backend

**Decisión:** Laravel 12 + PHP.

**Estado:** Aprobada.

**Motivo:** arquitectura MVC, ecosistema maduro y adecuación al proyecto.

## ADR-002 — Base de datos

**Decisión:** MySQL 8.4.

**Estado:** Aprobada.

**Restricción:** no utilizar MariaDB para ProUdeC.

## ADR-003 — Frontend

**Decisión:** Laravel Blade + CSS + JavaScript + Vite.

**Estado:** Aprobada.

**Restricción:** no introducir React salvo autorización explícita.

## ADR-004 — Control de versiones

**Decisión:** Git + GitHub.

## ADR-005 — Roles

Exactamente:

- Estudiante
- Docente
- Coordinador
- SuperAdmin

Existe un único SuperAdmin.

## ADR-006 — Competencias

Exactamente ocho competencias definidas en `requirements.md`.

Cada pregunta pertenece a una única competencia.

## ADR-007 — Fuente de preguntas

Existen:

- PLATFORM
- TEACHER

## ADR-008 — Tipos de preguntas

- MULTIPLE_CHOICE
- OPEN_TEXT

Las de selección tienen exactamente 4 opciones y una correcta.

Las abiertas tienen máximo 5.000 caracteres.

## ADR-009 — Preguntas exclusivas

Las preguntas exclusivas de ASSIGNED se almacenan separadamente y no ingresan al banco general.

## ADR-010 — Diagnóstico

291 preguntas:

- 290 cerradas;
- 1 abierta.

Una sola ejecución.

## ADR-011 — Evaluación final

291 preguntas:

- 290 cerradas;
- 1 abierta.

Se habilita después de finalizar las ocho competencias.

Tres intentos automáticos.

## ADR-012 — Prueba de competencia

20 preguntas.

Ocho intentos automáticos.

≥70 % de cerradas correctas finaliza la competencia.

## ADR-013 — Porcentaje

```text
cerradas correctas / total cerradas × 100
```

Las abiertas no participan.

Las cerradas sin responder cuentan como incorrectas.

## ADR-014 — Preguntas abiertas

Se califican por categorías:

- Incorrecta
- Parcialmente correcta
- Correcta

No afectan porcentaje ni finalización de competencia.

## ADR-015 — Calificadores

ASSIGNED:

- únicamente el creador.

DIAGNOSTIC/COMPETENCY/FINAL:

- docente activo autorizado por competencia;
- asignación aleatoria por estudiante/intent.

## ADR-016 — Recursos

Tipos:

- PDF
- PPT/PPTX
- imagen
- video
- enlace externo

Archivos fuera de BD.

## ADR-017 — Recursos Adicionales

Cada competencia tiene un tema por defecto llamado “Recursos Adicionales”.

No se elimina y siempre aparece al final.

## ADR-018 — Progreso de recursos

Abrir registra `last_viewed_at`.

Solo “Marcar como completado” establece `completed_at`.

## ADR-019 — Progreso visual

- Recursos = 90 %
- Prueba = 10 %

El progreso visual no equivale al desempeño académico.

## ADR-020 — Intentos

Estados:

- IN_PROGRESS
- SUBMITTED
- AUTO_SUBMITTED

Cerrar navegador no abandona.

Máximo un IN_PROGRESS por estudiante/evaluación.

## ADR-021 — Congelamiento

Al iniciar un intento se congelan preguntas, opciones, orden y condiciones relevantes.

Cambios posteriores no rompen el intento.

## ADR-022 — Snapshots

Los intentos almacenan snapshots para preservar historial.

No existe versionamiento formal de preguntas.

## ADR-023 — Desactivación

Preguntas: ACTIVE/INACTIVE.

La desactivación evita uso futuro y conserva historial.

## ADR-024 — Evaluaciones

Tipos:

- DIAGNOSTIC
- COMPETENCY
- FINAL
- ASSIGNED

Una tabla central.

## ADR-025 — Evaluaciones asignadas

Independientes del progreso de competencias.

## ADR-026 — Intentos adicionales

No modifican `evaluations.max_attempts`.

Se almacenan separadamente.

Coordinador puede conceder menos, nunca más que lo solicitado.

## ADR-027 — Notificaciones

Exclusivamente internas.

No se implementan notificaciones por correo como mecanismo normal.

## ADR-028 — Auditoría

Sistema central append-only.

No registrar secretos ni respuestas completas.

Retención: 1 año.

## ADR-029 — Seguridad de contraseñas

Argon2id.

## ADR-030 — Verificación institucional

Solo dominio exacto:

`@ucundinamarca.edu.co`

## ADR-031 — Cambio de contraseña

Invalida todas las sesiones activas.

## ADR-032 — Rate limit

Máximo 10 intentos de login en 30 segundos y limitación posterior.

## ADR-033 — Autorización

Laravel Policies/Gates + middleware.

## ADR-034 — Historial de usuarios

No realizar eliminación física cuando destruya trazabilidad académica.

Preferir desactivación/preservación.

## ADR-035 — SuperAdmin

Exactamente uno.

No puede crearse o promoverse un segundo SuperAdmin.

## ADR-036 — Competencias docentes

Relación N:M mediante `teacher_competencies`.

## ADR-037 — Reasignación

Si un docente pierde una competencia con tareas pendientes, estas pueden reasignarse a otro docente activo autorizado.

Debe auditarse y notificarse.

## ADR-038 — Selección de preguntas

La selección ocurre al iniciar el intento.

Se valida disponibilidad antes de crear el intento.

No existe sustitución silenciosa.

## ADR-039 — Repetición

Se evita repetir preguntas entre intentos cuando existe suficiente banco.

Si no existe suficiente disponibilidad, se permite reutilización.

## ADR-040 — Final vs diagnóstico

Se intenta excluir preguntas utilizadas en diagnóstico cuando existe suficiente banco.

## ADR-041 — IA

No existe IA como funcionalidad de ProUdeC.

El uso de agentes de IA para desarrollar el sistema no constituye una funcionalidad del producto.

## ADR-042 — Alcance

No ampliar el alcance sin decisión explícita.

## ADR-043 — Regla de cambios

Una modificación que contradiga una decisión aprobada requiere:

1. identificar la decisión afectada;
2. explicar el conflicto;
3. proponer alternativa;
4. recibir autorización;
5. actualizar este registro;
6. implementar.

## Plantilla para nuevas decisiones

### ADR-XXX — Título

**Estado:** Propuesta / Aprobada / Rechazada / Reemplazada

**Contexto:**

**Problema:**

**Alternativas:**

**Decisión:**

**Consecuencias:**

**Archivos afectados:**

**Fecha:**
