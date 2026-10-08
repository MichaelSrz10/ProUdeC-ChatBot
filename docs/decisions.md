# Decisiones de diseño

## Evaluación sin IA en el núcleo

La calificación de Saber Pro en ProUDEC no se delega a un modelo de lenguaje. El chatbot es un servicio de ayuda y orientación, aislado del hipotético motor de diagnóstico, pruebas por competencia, simulacro y calificación docente.

## Base de conocimiento en archivos JSON

No se crean tablas, migraciones ni columnas para el chatbot. El conocimiento vive en `resources/knowledge/*.json` versionados, con campo `source` hacia documentos del repositorio.

## Llamada al LLM solo en backend

La clave de Google AI Studio / Gemini vive en `.env`. El navegador nunca recibe la clave. El modelo configurado es `gemini-2.5-flash`.

## Dominio cerrado y veracidad

El asistente solo puede usar el bloque de conocimiento. Si un dato no está documentado o es contradictorio entre fuentes, no se afirma.

## Privacidad

No se envían a Gemini nombre, correo, código estudiantil ni resultados. Solo viajan el mensaje, un historial corto de sesión y el conocimiento público.

## Interruptor

`CHATBOT_ENABLED=false` oculta el widget y responde 404 en el endpoint, sin afectar el resto de ProUDEC.
