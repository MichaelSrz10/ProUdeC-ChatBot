# ProUdeC — UI/UX

## 1. Objetivo

La interfaz debe facilitar el aprendizaje, la práctica y la interpretación del desempeño.

Debe ser:

- responsive;
- clara;
- consistente;
- accesible;
- profesional;
- usable.

## 2. Tecnología

- Blade
- CSS
- JavaScript
- Vite
- Tailwind CSS según la configuración existente

No utilizar React por defecto.

## 3. Principios

- Jerarquía visual clara.
- Navegación predecible.
- Feedback inmediato cuando corresponda.
- Mensajes comprensibles.
- Estados visibles.
- Formularios accesibles.
- Diseño responsive.

## 4. Estudiante antes del diagnóstico

Puede acceder a:

- perfil;
- dashboard básico;
- diagnóstico.

Las ocho competencias aparecen bloqueadas.

No puede acceder a recursos o actividades académicas normales antes del diagnóstico.

## 5. Después del diagnóstico

Mostrar:

- resumen inmediato corto;
- acceso al dashboard;
- informe completo del diagnóstico desde el dashboard.

Las ocho competencias aparecen disponibles.

Las competencias que requieran más práctica deben destacarse visualmente sin bloquear las demás.

## 6. Vista de competencia

Cada competencia contiene exactamente dos secciones principales:

1. Recursos
2. Pruebas

No crear subcompetencias académicas.

Los temas organizan recursos, no competencias.

## 7. Recursos

Los recursos deben mostrar:

- título;
- tipo;
- tema;
- estado de completitud;
- acción de abrir/consultar;
- acción de marcar completado cuando corresponda.

Abrir registra consulta.

Marcar completado es explícito.

## 8. Orden

Los temas tienen orden configurable.

“Recursos Adicionales” aparece siempre al final.

Los recursos tienen orden dentro de cada tema.

## 9. Barra de progreso

La barra muestra progreso visual:

- 90 % recursos;
- 10 % prueba.

Debe distinguir visualmente:

- progreso;
- desempeño;
- finalización académica.

No presentar la barra como si fuera una nota.

## 10. Prueba

Antes de iniciar:

- número de preguntas;
- tiempo;
- intentos;
- instrucciones;
- advertencias;
- botón comenzar.

Durante:

- una pregunta por pantalla;
- anterior;
- siguiente;
- panel de navegación;
- contador persistente.

## 11. Finalizar

Siempre pedir confirmación.

Si existen preguntas sin responder, indicar cuántas.

No impedir finalizar por preguntas sin responder.

## 12. Resultado

Después de finalizar mostrar:

- porcentaje cuantitativo;
- preguntas correctas/incorrectas;
- respuesta propia;
- respuesta correcta cuando aplique;
- retroalimentación general;
- preguntas sin responder.

Las abiertas deben indicar:

`Pendiente de calificación`

hasta que el docente publique la calificación.

## 13. Preguntas abiertas

El estudiante puede ver su propia respuesta inmediatamente.

La calificación y retroalimentación aparecen únicamente después de publicación.

## 14. Docente

La interfaz debe respetar sus competencias autorizadas.

Debe contar con:

### Recursos

- Gestionar temas
- Crear recurso
- Modificar recursos propios
- Eliminar/desactivar recursos propios

### Pruebas

- Crear prueba
- Modificar si no existen intentos iniciados
- Desactivar

### Calificaciones

- Calificadas
- Por calificar
- Asignadas

## 15. Coordinador

Dashboard:

1. Estudiantes
2. Docentes
3. Competencias
4. Preguntas
5. Recursos
6. Pruebas/Evaluaciones
7. Calificaciones
8. Solicitudes de intentos adicionales
9. Analítica/Desempeño
10. Auditoría

## 16. Notificaciones

Las notificaciones deben ser internas y permitir:

- ver;
- marcar como leída;
- consultar contexto.

## 17. Accesibilidad

Considerar:

- contraste;
- foco visible;
- navegación por teclado;
- labels;
- mensajes de validación;
- tamaño adecuado de controles;
- semántica HTML.

## 18. Responsive

Diseñar para:

- escritorio;
- tablet;
- móvil.

Las evaluaciones deben ser especialmente usables en pantallas pequeñas.

## 19. Mensajes

Evitar mensajes técnicos.

Preferir:

```text
No hay suficientes preguntas disponibles para generar esta evaluación.
Solicitadas: 20
Disponibles: 14
```

en lugar de errores internos.

## 20. Consistencia

Utilizar patrones consistentes para:

- botones;
- formularios;
- tablas;
- estados;
- alertas;
- confirmaciones;
- modales;
- navegación.

## 21. Regla

La UI nunca sustituye las reglas de backend.
