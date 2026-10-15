# ProUDEC — contexto maestro

Documento de referencia construido a partir del repositorio vigente (README, vistas y código). No describe funcionalidades que no existan en el código ni cifras que contradigan otras pantallas.

## Qué es

ProUDEC es un proyecto de gestión del conocimiento: una plataforma web para potenciar las habilidades evaluadas en Saber Pro de los estudiantes de Ingeniería de Sistemas y Computación de la Universidad de Cundinamarca, Seccional Ubaté.

## Propósito

Fortalecer competencias genéricas y específicas asociadas a Saber Pro mediante una plataforma educativa institucional, accesible para la comunidad académica de la seccional.

## Contexto institucional

- Institución: Universidad de Cundinamarca
- Sede: Seccional Ubaté
- Programa: Ingeniería de Sistemas y Computación
- Referente de evaluación externa: Saber Pro

## Qué está implementado hoy en el código

- Página pública (`/`) que presenta el proyecto, beneficios y objetivos.
- Registro de usuarios (`/register`) y autenticación (`/login`, `/logout`).
- Panel autenticado (`/dashboard`) con menú de navegación (contenidos, simulacros, resultados, perfil, configuración) como interfaz de trabajo.
- Formulario de contacto por POST (`/contacto`).
- Chatbot informativo aislado del núcleo de evaluación (no califica, no lee la base de datos de resultados).

## Qué no está modelado aún en datos

- No hay columna de roles en `users`.
- No hay migraciones de banco de preguntas, intentos, recursos ni notificaciones.
- El núcleo de evaluación (diagnóstico, pruebas por competencia, simulacro final, calificación docente) no está implementado como motor en este repositorio.

Las cifras promocionales de la página pública (por ejemplo número de preguntas o de competencias) no se tratan como hechos verificados porque no coinciden con otras vistas y no hay tablas que las respalden.
