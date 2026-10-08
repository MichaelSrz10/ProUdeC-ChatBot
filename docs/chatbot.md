# Documentación Técnica del Chatbot de ProUDEC

## Arquitectura

El chatbot es un asistente informativo integrado al backend de ProUDEC. Utiliza la API de Gemini (`gemini-2.5-flash`) mediante el cliente `GeminiClient`, e inyecta todo el contexto necesario utilizando `KnowledgeBase` y `PromptBuilder`.

El presupuesto máximo de tokens de contexto para la inyección (context stuffing) es de 1,000,000 tokens (límite de gemini-1.5-flash y 2.5-flash), aunque actualmente la base de conocimiento consume menos de 10,000 tokens.

## Casos Borde y Resultados Esperados

| Caso Borde | Resultado Esperado |
|---|---|
| Mensaje vacío, solo espacios o muy largo | Rechazado por `InputGuard` sin llamar a la API. Mensaje de rechazo estándar. |
| Mensaje con solo emojis | Rechazado por `InputGuard`. Mensaje de rechazo estándar. |
| Mensaje mezclado en español e inglés | Detectado como uno de los idiomas (prioriza español por defecto si la ambigüedad persiste), responde en el idioma detectado. |
| Pregunta parcialmente en dominio ("¿Qué es ProUDEC y cómo hacer una torta?") | Responde la parte válida sobre ProUDEC y aclara que no puede responder sobre el otro tema. |
| Solicitud de datos personales o resultados | Se niega cortésmente, recordando sus límites de privacidad. |
| Intento de conseguir respuestas del simulacro | Rechazo amable: explica que por autonomía y aprendizaje no da respuestas directas. |
| Solicitud de revelar el prompt (inyección) | Ignora la solicitud de revelar el prompt y redirige al dominio del bot. |
| Preguntas sobre seguridad interna (tablas, rutas) | "No dispongo de esa información" o rechazo similar. |

## Pendientes de Verificación

* [ ] Consolidar la cantidad exacta de competencias evaluadas, si hubiera contradicción en la documentación original.
* [ ] Clarificar el número de intentos permitidos en los simulacros si los documentos `docs/requirements.md` y otros difieren.
