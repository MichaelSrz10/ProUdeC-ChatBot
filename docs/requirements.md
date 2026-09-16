# ProUdeC — Requisitos del sistema

## 1. Propósito

ProUdeC es una plataforma web para fortalecer las competencias evaluadas en Saber Pro, dirigida a estudiantes de Ingeniería de Sistemas y Computación de la Universidad de Cundinamarca, Seccional Ubaté.

La plataforma permite diagnosticar el desempeño, estudiar mediante recursos, practicar mediante evaluaciones, realizar seguimiento y comparar el desempeño diagnóstico con la evaluación final.

ProUdeC no es el examen oficial Saber Pro y sus resultados internos no deben presentarse como puntajes oficiales del ICFES.

## 2. Objetivos

### Objetivo general

Desarrollar una plataforma web para el fortalecimiento de las competencias evaluadas en el examen de estado Saber Pro, dirigida a los estudiantes de Ingeniería de Sistemas y Computación de la Universidad de Cundinamarca, Seccional Ubaté.

### Objetivos específicos

1. Determinar las falencias académicas y los requisitos funcionales de los estudiantes mediante el análisis de los componentes evaluados en las guías oficiales del ICFES Saber Pro.
2. Modelar la arquitectura del software, el diseño UI/UX y la estructura de la base de datos necesaria para la persistencia de los simulacros.
3. Codificar los módulos de la plataforma web utilizando tecnologías orientadas a entornos virtuales de aprendizaje y herramientas de seguimiento ágil.
4. Validar la evolución/cambio del desempeño mediante pruebas piloto, incluyendo diagnóstico/pre-test y evaluación final/post-test.

## 3. Alcance

### Incluido

- Registro y autenticación.
- Verificación del correo institucional.
- Roles: Estudiante, Docente, Coordinador y SuperAdmin.
- Diagnóstico obligatorio.
- Ocho competencias.
- Recursos educativos.
- Banco de preguntas.
- Preguntas de selección múltiple y abiertas.
- Pruebas por competencia.
- Evaluaciones asignadas por docentes.
- Simulación final.
- Calificación de preguntas abiertas.
- Intentos adicionales.
- Notificaciones internas.
- Auditoría.
- Analítica de desempeño.
- Exportación CSV y Excel.
- Prueba piloto y comparación diagnóstico/final.

### Fuera del alcance actual

- IA como funcionalidad del producto.
- Gamificación.
- Aplicación móvil nativa.
- Multiuniversidad/multitenancy.
- Microservicios.
- Integraciones externas no definidas.
- Conversión del porcentaje interno a puntaje oficial ICFES.
- Chatbot o generación automática de preguntas.

## 4. Competencias

1. Lectura Crítica
2. Razonamiento Cuantitativo
3. Competencias Ciudadanas
4. Comunicación Escrita
5. Inglés
6. Diseño de software
7. Formulación de proyectos de ingeniería
8. Pensamiento científico

Cada pregunta pertenece a una sola competencia.

## 5. Roles

### Estudiante

- Registro público.
- Verificación institucional.
- Diagnóstico.
- Acceso a competencias.
- Consulta de recursos.
- Pruebas.
- Evaluaciones asignadas.
- Consulta de resultados y evolución.

### Docente

- Acceso a competencias autorizadas.
- Gestión de temas y recursos propios.
- Creación y gestión de preguntas propias.
- Creación de evaluaciones asignadas.
- Calificación de respuestas abiertas que le correspondan.
- Consulta de desempeño dentro de sus competencias.
- Exportación de reportes.

### Coordinador

- Administración de docentes.
- Gestión de competencias docentes.
- Gestión institucional de preguntas y recursos.
- Administración de evaluaciones.
- Gestión de solicitudes de intentos adicionales.
- Gestión/reasignación de calificaciones.
- Analítica institucional.
- Auditoría.

### SuperAdmin

Control administrativo total dentro de las reglas del proyecto.

Debe existir exactamente un SuperAdmin.

## 6. Flujo principal

```text
Registro
→ Verificación de correo
→ Login
→ Diagnóstico obligatorio
→ Perfil inicial
→ 8 competencias
→ Recursos + pruebas
→ Finalización de competencias
→ Evaluación final
→ Comparación diagnóstico/final
```

## 7. Diagnóstico

El diagnóstico es obligatorio y funciona como pre-test/baseline.

Debe contener exactamente 291 preguntas:

- 290 cerradas.
- 1 abierta.

Distribución de preguntas cerradas:

| Competencia | Cerradas |
|---|---:|
| Lectura Crítica | 35 |
| Razonamiento Cuantitativo | 35 |
| Competencias Ciudadanas | 35 |
| Inglés | 55 |
| Comunicación Escrita | 0 |
| Diseño de software | 40 |
| Formulación de proyectos de ingeniería | 40 |
| Pensamiento científico | 50 |
| Total | 290 |

La pregunta abierta corresponde a Comunicación Escrita.

El diagnóstico se realiza una sola vez.

## 8. Pruebas por competencia

Cada competencia tiene una prueba principal de 20 preguntas.

La selección es aleatoria y debe evitar repeticiones exactas cuando exista suficiente banco disponible.

Cada estudiante dispone inicialmente de 8 intentos automáticos.

Una competencia queda académicamente finalizada cuando cualquier intento alcanza al menos 70 % de respuestas cerradas correctas.

Finalizar una competencia no bloquea la práctica posterior.

## 9. Evaluación final

Se desbloquea cuando las ocho competencias han sido finalizadas.

Contiene exactamente 291 preguntas:

- 290 cerradas.
- 1 abierta.

Mantiene la distribución del diagnóstico.

Dispone de 3 intentos automáticos.

Cuando sea posible, se excluyen preguntas utilizadas en el diagnóstico.

## 10. Evaluaciones asignadas

Son independientes del progreso de competencias.

El docente puede seleccionar estudiantes y configurar una evaluación de una sola competencia.

Puede utilizar preguntas del banco general y preguntas exclusivas.

Las preguntas exclusivas pertenecen únicamente a esa evaluación y no ingresan al banco general.

El creador de la evaluación es el único docente que puede calificar sus respuestas abiertas.

## 11. Preguntas

### Selección múltiple

- 4 opciones exactas.
- 1 opción correcta.

### Abiertas

- Máximo 5.000 caracteres.
- Sin opciones.
- Requieren calificación docente.

Resultados:

- Incorrecta.
- Parcialmente correcta.
- Correcta.

Las preguntas abiertas no afectan el porcentaje cuantitativo.

## 12. Cálculo de desempeño

```text
porcentaje =
respuestas cerradas correctas /
total de preguntas cerradas × 100
```

Las preguntas cerradas sin responder cuentan como incorrectas.

Las preguntas abiertas no participan.

## 13. Intentos

Estados:

- IN_PROGRESS
- SUBMITTED
- AUTO_SUBMITTED

Cerrar el navegador no abandona un intento.

El estudiante puede reanudarlo mientras el tiempo siga vigente.

El backend es la autoridad temporal.

Solo puede existir un intento IN_PROGRESS por estudiante/evaluación.

## 14. Progreso de competencias

El progreso visual no representa directamente desempeño académico.

- Recursos: 90 %.
- Prueba presentada: 10 %.

La barra puede alcanzar 100 % aunque el resultado de la prueba sea inferior a 70 %.

La finalización académica depende exclusivamente del criterio de ≥70 % de respuestas cerradas correctas.

## 15. Recursos

Tipos:

- PDF
- PPT/PPTX
- Imagen
- Video
- Enlace externo

Los archivos se almacenan fuera de la base de datos.

Cada recurso pertenece a una competencia y puede pertenecer a un tema.

Sin tema explícito, se asigna a “Recursos Adicionales”.

## 16. Progreso de recursos

Abrir un recurso registra `last_viewed_at`.

Solo la acción explícita “Marcar como completado” establece `completed_at`.

Reabrir no incrementa el progreso.

## 17. Seguridad

- Hashing de contraseñas con Argon2id.
- Verificación de correo institucional.
- Recuperación por correo institucional.
- Rate limit de login: máximo 10 intentos en 30 segundos.
- Cambio de contraseña invalida sesiones activas.
- Múltiples sesiones permitidas.
- CSRF estándar de Laravel.
- Policies/Gates y middleware.
- Validación estricta de archivos.
- Auditoría sin secretos ni respuestas completas.

## 18. Notificaciones

Las notificaciones son internas.

Casos principales:

- solicitud de intentos adicionales;
- decisión sobre intentos;
- asignación de calificación;
- reasignación;
- modificación administrativa de preguntas.

## 19. Auditoría

La auditoría es append-only y registra operaciones administrativas y académicas relevantes.

Retención definida: 1 año.

## 20. Analítica

Debe permitir:

- diagnóstico global;
- resultados por competencia;
- historial de intentos;
- mejores resultados;
- progreso;
- evaluaciones asignadas;
- comparación diagnóstico/final;
- resultados de preguntas cerradas;
- estado de preguntas abiertas.

La fuente de verdad histórica son los intentos y sus respuestas/snapshots.

## 21. Criterio general de implementación

Los requisitos aquí descritos son funcionales. No deben ser alterados por el agente sin registrar una nueva decisión y obtener autorización cuando el cambio afecte comportamiento, arquitectura, seguridad, datos o alcance.
