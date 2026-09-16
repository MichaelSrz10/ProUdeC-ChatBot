# ProUdeC — Seguridad

## 1. Principios

- Seguridad por defecto.
- Mínimo privilegio.
- Validación en servidor.
- Defensa en profundidad.
- Protección de datos históricos.
- No confiar en el cliente.
- No registrar secretos.

## 2. Contraseñas

Utilizar Argon2id mediante la infraestructura de Laravel.

Nunca almacenar contraseñas en texto plano.

Nunca mostrar contraseñas.

## 3. Registro

Solo estudiantes tienen registro público.

Los estudiantes deben usar exactamente:

`@ucundinamarca.edu.co`

El correo debe verificarse antes del acceso académico.

## 4. Verificación

Un estudiante no verificado no puede acceder a:

- recursos académicos;
- pruebas;
- diagnóstico;
- resultados académicos.

La cuenta no verificada se desactiva automáticamente después de 3 horas según la regla definida.

## 5. Recuperación

La recuperación se realiza mediante enlace temporal enviado al correo institucional.

No revelar si una cuenta existe de forma que facilite enumeración de usuarios.

## 6. Sesiones

Cambio de contraseña:

- invalida sesiones activas.

Se permiten múltiples sesiones simultáneas.

## 7. Rate limiting

Login:

- máximo 10 intentos;
- ventana de 30 segundos;
- posterior limitación temporal.

Implementar en backend.

## 8. CSRF

Utilizar protección CSRF estándar de Laravel.

No deshabilitar globalmente.

## 9. Autorización

Usar:

- middleware;
- Policies;
- Gates cuando sea apropiado.

Cada operación sensible debe comprobar:

- usuario;
- rol;
- propiedad;
- competencia autorizada;
- estado de entidad.

## 10. IDOR

No confiar en IDs enviados por URL o formulario.

Ejemplo:

Un docente no puede consultar una evaluación de otro contexto simplemente cambiando un ID.

## 11. Preguntas

El acceso a preguntas debe verificar permisos.

Reglas principales:

- creador de pregunta TEACHER: puede administrar propias;
- Coordinador: puede administrar preguntas a las que tenga acceso institucional;
- SuperAdmin: total;
- otros docentes: pueden consultar/utilizar preguntas cuando estén autorizados sobre la competencia, pero no editar preguntas ajenas.

## 12. Recursos

Aplicar autorización equivalente.

Un docente puede gestionar sus recursos dentro de competencias autorizadas.

Coordinador/SuperAdmin tienen administración superior.

## 13. Archivos

Validar:

- extensión;
- MIME;
- tamaño;
- almacenamiento.

Límites:

- video propio: 500 MB;
- PDF/PPT/PPTX/imagen: 20 MB.

El nombre físico es generado por el sistema.

No confiar en el nombre enviado por el usuario.

## 14. Almacenamiento

Los archivos se almacenan fuera de la base de datos.

No exponer rutas físicas internas de manera innecesaria.

## 15. XSS

Escapar contenido en Blade.

Cuando se permita HTML explícitamente, sanitizarlo.

No utilizar renderizado HTML sin necesidad.

## 16. SQL Injection

Utilizar Eloquent/query builder y parámetros seguros.

No concatenar input del usuario en SQL.

## 17. Mass Assignment

Configurar correctamente `$fillable`/`$guarded`.

No permitir asignación arbitraria de campos sensibles.

## 18. Evaluaciones

El frontend no puede determinar:

- si un intento es válido;
- si un estudiante tiene intentos;
- cuándo termina;
- si aprobó;
- qué preguntas puede recibir.

Todo debe comprobarse en backend.

## 19. Tiempo

El servidor es la autoridad.

El cliente no puede extender el tiempo modificando JavaScript.

## 20. Preguntas históricas

Nunca confiar en la pregunta actual para reconstruir un intento histórico.

Usar snapshots.

## 21. Auditoría

Auditar:

- login exitoso/fallido;
- logout;
- cambios de rol;
- administración de usuarios;
- cambios de preguntas;
- cambios de recursos;
- cambios de evaluaciones;
- asignaciones;
- inicio de intentos;
- envío manual;
- auto-submit;
- decisiones de intentos adicionales;
- publicación de calificaciones;
- reasignaciones.

No registrar:

- contraseñas;
- tokens;
- secretos;
- respuestas completas del estudiante.

## 22. Privacidad

Un estudiante solo puede acceder a sus propios resultados.

Los docentes solo pueden consultar datos dentro de sus competencias autorizadas.

Coordinador y SuperAdmin tienen acceso institucional según permisos.

## 23. Integridad

Evitar eliminación destructiva de:

- intentos;
- respuestas;
- snapshots;
- calificaciones;
- auditoría.

## 24. Producción

No exponer:

- `APP_DEBUG=true`;
- stack traces;
- secretos;
- credenciales.

Los detalles técnicos deben quedar en logs internos apropiados.

## 25. Dependencias

Antes de agregar una dependencia:

- evaluar seguridad;
- mantenimiento;
- licencia;
- necesidad;
- alternativas nativas.

No agregar paquetes innecesarios.

## 26. Principio de seguridad final

Toda regla de seguridad debe cumplirse aunque el usuario manipule:

- formularios;
- URL;
- JavaScript;
- peticiones HTTP;
- IDs;
- cantidades;
- estados.

El navegador no es una fuente confiable.
