@if (config('chatbot.enabled'))
@php
    $locale = str_starts_with(strtolower(app()->getLocale()), 'en') ? 'en' : 'es';
    $labels = [
        'es' => [
            'launcher' => 'Abrir asistente de ProUDEC',
            'close' => 'Cerrar chat',
            'title' => 'Asistente ProUDEC',
            'subtitle' => 'Orientación & Saber Pro IA',
            'status' => 'En línea',
            'dialog' => 'Chat del asistente de ProUDEC',
            'disclaimer' => 'Asistente de IA institucional. No reemplaza al docente ni a los resultados oficiales.',
            'placeholder' => 'Escribe tu pregunta sobre ProUDEC…',
            'send' => 'Enviar',
            'reset' => 'Reiniciar conversación',
            'badge' => 'Asistente IA',
            'welcome' => '¡Hola! Soy tu asistente virtual de ProUDEC. Puedo orientarte sobre las funciones de la plataforma, preparación Saber Pro y la aplicación de la Declaración de la Persona Transhumana.',
            'suggestions_title' => 'Preguntas sugeridas',
            'suggestions' => [
                '¿Qué es ProUDEC y su propósito?',
                '¿Qué funcionalidades tiene la plataforma?',
                '¿Cómo se aplica la Declaración Transhumana?',
            ],
            'messages' => 'Mensajes',
        ],
        'en' => [
            'launcher' => 'Open ProUDEC assistant',
            'close' => 'Close chat',
            'title' => 'ProUDEC Assistant',
            'subtitle' => 'Institutional Guide & Saber Pro AI',
            'status' => 'Online',
            'dialog' => 'ProUDEC assistant chat',
            'disclaimer' => 'Institutional AI assistant. It does not replace your instructor or official results.',
            'placeholder' => 'Type your question about ProUDEC…',
            'send' => 'Send',
            'reset' => 'Reset conversation',
            'badge' => 'AI Assistant',
            'welcome' => 'Hello! I am your ProUDEC virtual assistant. I can help with platform features, Saber Pro preparation, and the Transhuman Person Declaration.',
            'suggestions_title' => 'Suggested questions',
            'suggestions' => [
                'What is ProUDEC and its purpose?',
                'What features does the platform have?',
                'How is the Transhuman Declaration applied?',
            ],
            'messages' => 'Messages',
        ],
    ];
    $t = $labels[$locale];
@endphp
    @once
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @unless (app()->environment('testing'))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endunless
    @endonce
    <div
        id="proudec-chatbot"
        class="proudec-chatbot"
        data-csrf="{{ csrf_token() }}"
        data-enabled="1"
    >
        <!-- Floating Launcher Button -->
        <button
            type="button"
            class="proudec-chatbot__launcher"
            data-chatbot-launcher
            aria-expanded="false"
            aria-controls="proudec-chatbot-panel"
            aria-label="{{ $t['launcher'] }}"
        >
            <div class="proudec-chatbot__launcher-pill">
                <span class="proudec-chatbot__pulse-dot"></span>
                <span>{{ $t['badge'] }}</span>
            </div>
            <div class="proudec-chatbot__launcher-icon-wrap">
                <!-- Chat SVG Icon (Default) -->
                <svg class="proudec-chatbot__launcher-icon proudec-chatbot__launcher-icon--open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                    <path d="M9.5 10.5h.01M14.5 10.5h.01"/>
                    <path d="M9.5 14a3.5 3.5 0 0 0 5 0"/>
                </svg>
                <!-- Close SVG Icon (When Open) -->
                <svg class="proudec-chatbot__launcher-icon proudec-chatbot__launcher-icon--close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </div>
        </button>

        <!-- Chat Panel Window -->
        <div
            id="proudec-chatbot-panel"
            class="proudec-chatbot__panel"
            role="dialog"
            aria-label="{{ $t['dialog'] }}"
            aria-modal="false"
            data-chatbot-panel
            hidden
        >
            <!-- Panel Header -->
            <div class="proudec-chatbot__header">
                <div class="proudec-chatbot__header-info">
                    <div class="proudec-chatbot__avatar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="10" rx="2"></rect>
                            <circle cx="12" cy="5" r="2"></circle>
                            <path d="M12 7v4"></path>
                            <line x1="8" y1="16" x2="8" y2="16"></line>
                            <line x1="16" y1="16" x2="16" y2="16"></line>
                        </svg>
                        <span class="proudec-chatbot__avatar-status" title="{{ $t['status'] }}"></span>
                    </div>
                    <div class="proudec-chatbot__header-text">
                        <h2>{{ $t['title'] }}</h2>
                        <span class="proudec-chatbot__subtitle">{{ $t['subtitle'] }}</span>
                    </div>
                </div>
                <div class="proudec-chatbot__header-actions">
                    <button type="button" class="proudec-chatbot__action-btn" data-chatbot-reset title="{{ $t['reset'] }}" aria-label="{{ $t['reset'] }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                            <path d="M3 3v5h5"></path>
                        </svg>
                    </button>
                    <button type="button" class="proudec-chatbot__close" data-chatbot-close aria-label="{{ $t['close'] }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Disclaimer Notice -->
            <div class="proudec-chatbot__disclaimer">
                <svg class="proudec-chatbot__disclaimer-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
                <span>{{ $t['disclaimer'] }}</span>
            </div>

            <!-- Messages Log -->
            <div
                class="proudec-chatbot__log"
                data-chatbot-log
                role="log"
                aria-live="polite"
                aria-label="{{ $t['messages'] }}"
            >
                <x-chatbot.message role="assistant" :text="$t['welcome']" />
            </div>

            <!-- Suggestions -->
            <div class="proudec-chatbot__suggestions-wrap">
                <span class="proudec-chatbot__suggestions-label">{{ $t['suggestions_title'] }}</span>
                <div class="proudec-chatbot__suggestions" data-chatbot-suggestions>
                    @foreach ($t['suggestions'] as $suggestion)
                        <button type="button" class="proudec-chatbot__chip">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="proudec-chatbot__chip-icon">
                                <path d="m12 3-1.9 5.8a2 2 0 0 1-1.3 1.3L3 12l5.8 1.9a2 2 0 0 1 1.3 1.3L12 21l1.9-5.8a2 2 0 0 1 1.3-1.3L21 12l-5.8-1.9a2 2 0 0 1-1.3-1.3Z"></path>
                            </svg>
                            <span>{{ $suggestion }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Input Form -->
            <form class="proudec-chatbot__form" data-chatbot-form>
                <label class="visually-hidden" for="proudec-chatbot-input" style="position:absolute;left:-9999px;">
                    {{ $t['placeholder'] }}
                </label>
                <div class="proudec-chatbot__input-box">
                    <input
                        id="proudec-chatbot-input"
                        class="proudec-chatbot__input"
                        data-chatbot-input
                        type="text"
                        maxlength="{{ (int) config('chatbot.max_input_chars') }}"
                        placeholder="{{ $t['placeholder'] }}"
                        autocomplete="off"
                    >
                    <button type="submit" class="proudec-chatbot__send" aria-label="{{ $t['send'] }}">
                        <span class="proudec-chatbot__send-label" data-submit-label>{{ $t['send'] }}</span>
                        <svg class="proudec-chatbot__send-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Bottom Reset Button -->
            <button type="button" class="proudec-chatbot__reset" data-chatbot-reset>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                    <path d="M3 3v5h5"></path>
                </svg>
                <span>{{ $t['reset'] }}</span>
            </button>
        </div>
    </div>
@endif
