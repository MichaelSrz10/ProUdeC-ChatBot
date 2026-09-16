# ProUdeC — Estrategia de pruebas

## 1. Objetivo

Garantizar que las funcionalidades sean correctas, seguras, mantenibles y resistentes a casos límite.

## 2. Niveles

### Unitarias

Para lógica aislada:

- cálculos;
- reglas;
- selección;
- servicios;
- validadores.

### Feature/Integración

Para flujos completos:

- autenticación;
- autorización;
- evaluaciones;
- intentos;
- calificación;
- recursos;
- notificaciones.

### Browser/UI

Cuando sea necesario para flujos críticos.

## 3. Regla

Toda funcionalidad nueva relevante debe incluir pruebas.

## 4. Autenticación

Probar:

- registro;
- correo no institucional;
- verificación;
- login;
- login incorrecto;
- rate limit;
- recuperación;
- cambio de contraseña;
- invalidación de sesiones.

## 5. Autorización

Probar cada acción sensible con:

- usuario correcto;
- rol incorrecto;
- docente con otra competencia;
- estudiante;
- usuario desactivado;
- recurso ajeno.

## 6. Diagnóstico

Probar:

- una sola ejecución;
- 291 preguntas;
- 290 cerradas;
- 1 abierta;
- distribución exacta;
- selección aleatoria;
- snapshot;
- no repetición cuando exista disponibilidad.

## 7. Competencias

Probar:

- 20 preguntas;
- hasta 8 intentos;
- ≥70 % finaliza;
- <70 % no finaliza;
- preguntas abiertas excluidas;
- preguntas sin responder cuentan como incorrectas;
- reutilización cuando el banco sea insuficiente.

## 8. Evaluación final

Probar:

- bloqueo antes de finalizar competencias;
- desbloqueo después de las ocho;
- 291 preguntas;
- 3 intentos;
- exclusión del diagnóstico cuando sea posible.

## 9. Evaluaciones asignadas

Probar:

- selección de estudiantes;
- una competencia;
- fuente PLATFORM/TEACHER;
- preguntas exclusivas;
- configuración inválida;
- insuficiencia de banco;
- congelamiento después del primer intento;
- independencia del progreso de competencias.

## 10. Tiempo

Probar:

- reanudación;
- expiración;
- auto-submit;
- manipulación del reloj del cliente;
- cierre del navegador;
- intento ya expirado.

## 11. Concurrencia

Probar especialmente:

- dos inicios simultáneos;
- dos solicitudes adicionales simultáneas;
- consumo de último intento;
- asignaciones concurrentes.

## 12. Respuestas

Probar:

- correcta;
- incorrecta;
- sin responder;
- respuesta abierta;
- límite 5.000 caracteres;
- publicación de calificación.

## 13. Snapshots

Prueba obligatoria:

1. crear pregunta;
2. iniciar intento;
3. modificar pregunta;
4. comprobar que el intento conserva la versión original.

## 14. Desactivación

Probar que:

- pregunta inactiva no aparece en nuevas selecciones;
- recurso inactivo no aparece al estudiante;
- evaluación inactiva no recibe nuevas ejecuciones;
- historial permanece.

## 15. Intentos adicionales

Probar:

- solicitud;
- una sola pendiente;
- aprobación;
- rechazo;
- razón obligatoria;
- cantidad concedida ≤ solicitada;
- disponibilidad futura;
- auditoría;
- notificaciones.

## 16. Calificación

Probar:

- asignación aleatoria válida;
- ausencia de docente autorizado;
- reasignación;
- guardado de borrador;
- invisibilidad del borrador;
- publicación;
- modificación posterior;
- auditoría.

## 17. Recursos

Probar:

- creación;
- tema;
- Recursos Adicionales;
- orden;
- archivo válido;
- archivo inválido;
- tamaño excedido;
- desactivación;
- progreso.

## 18. Analítica

Verificar:

- porcentaje;
- mejor resultado;
- diagnóstico;
- final;
- comparación;
- datos históricos;
- exclusión de entidades desactivadas de indicadores futuros cuando corresponda.

## 19. Seguridad

Probar:

- CSRF;
- IDOR;
- autorización;
- XSS;
- validación;
- upload;
- mass assignment;
- exposición de información.

## 20. Criterio de aceptación

Una tarea no se considera terminada si:

- las pruebas relevantes no fueron ejecutadas;
- existen fallos conocidos no reportados;
- la funcionalidad solo funciona en frontend;
- se rompe una regla de autorización;
- se altera historial.

## 21. Informe

Cada implementación debe indicar:

```text
Pruebas ejecutadas:
Resultado:
Fallos:
Pendientes:
```
