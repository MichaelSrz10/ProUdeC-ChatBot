export const labels = {
    es: {
        launcher: 'Abrir asistente de ProUDEC',
        close: 'Cerrar chat',
        title: 'Asistente ProUDEC',
        dialog: 'Chat del asistente de ProUDEC',
        disclaimer: 'Asistente de IA. No reemplaza al docente ni a los resultados oficiales.',
        placeholder: 'Escribe tu pregunta…',
        send: 'Enviar',
        sending: 'Enviando',
        reset: 'Reiniciar conversación',
        welcome:
            'Hola. Puedo orientarte sobre ProUDEC, sus funcionalidades documentadas y la Declaración de la Persona Transhumana.',
        suggestions: [
            '¿Qué es ProUDEC?',
            '¿Qué funcionalidades tiene?',
            '¿Cómo se aplica la Declaración Transhumana?',
        ],
        typing: 'Escribiendo…',
        retry: 'Reintentar',
        error: 'No se pudo obtener respuesta.',
        unavailable: 'El asistente no está disponible en este momento.',
        rateLimited: 'Has alcanzado el límite de solicitudes. Espera un minuto.',
        messages: 'Mensajes',
    },
    en: {
        launcher: 'Open ProUDEC assistant',
        close: 'Close chat',
        title: 'ProUDEC assistant',
        dialog: 'ProUDEC assistant chat',
        disclaimer: 'AI assistant. It does not replace your instructor or official results.',
        placeholder: 'Type your question…',
        send: 'Send',
        sending: 'Sending',
        reset: 'Reset conversation',
        welcome:
            'Hello. I can help with ProUDEC, its documented features, and the Transhuman Person Declaration.',
        suggestions: [
            'What is ProUDEC?',
            'What features does it have?',
            'How is the Transhuman Declaration applied?',
        ],
        typing: 'Typing…',
        retry: 'Retry',
        error: 'The reply could not be retrieved.',
        unavailable: 'The assistant is unavailable right now.',
        rateLimited: 'You have reached the request limit. Please wait a minute.',
        messages: 'Messages',
    },
};

export function interfaceLanguage() {
    const htmlLang = (document.documentElement.lang || 'es').toLowerCase();

    return htmlLang.startsWith('en') ? 'en' : 'es';
}
