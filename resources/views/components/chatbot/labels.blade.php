@php
    $locale = str_starts_with(strtolower(app()->getLocale()), 'en') ? 'en' : 'es';
    $labels = [
        'es' => [
            'launcher' => 'Abrir asistente de ProUDEC',
            'close' => 'Cerrar chat',
            'title' => 'Asistente ProUDEC',
            'dialog' => 'Chat del asistente de ProUDEC',
            'disclaimer' => 'Asistente de IA. No reemplaza al docente ni a los resultados oficiales.',
            'placeholder' => 'Escribe tu pregunta…',
            'send' => 'Enviar',
            'reset' => 'Reiniciar conversación',
            'welcome' => 'Hola. Puedo orientarte sobre ProUDEC, sus funcionalidades documentadas y la Declaración de la Persona Transhumana.',
            'suggestions' => [
                '¿Qué es ProUDEC?',
                '¿Qué funcionalidades tiene?',
                '¿Cómo se aplica la Declaración Transhumana?',
            ],
            'messages' => 'Mensajes',
        ],
        'en' => [
            'launcher' => 'Open ProUDEC assistant',
            'close' => 'Close chat',
            'title' => 'ProUDEC assistant',
            'dialog' => 'ProUDEC assistant chat',
            'disclaimer' => 'AI assistant. It does not replace your instructor or official results.',
            'placeholder' => 'Type your question…',
            'send' => 'Send',
            'reset' => 'Reset conversation',
            'welcome' => 'Hello. I can help with ProUDEC, its documented features, and the Transhuman Person Declaration.',
            'suggestions' => [
                'What is ProUDEC?',
                'What features does it have?',
                'How is the Transhuman Declaration applied?',
            ],
            'messages' => 'Messages',
        ],
    ];
    $t = $labels[$locale];
@endphp
