@props([
    'role' => 'assistant',
    'text' => '',
])

<article class="proudec-chatbot__bubble proudec-chatbot__bubble--{{ $role }}">
    @if ($role === 'assistant')
        <div class="proudec-chatbot__bubble-author">
            <span class="proudec-chatbot__bubble-avatar">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="10" rx="2"></rect>
                    <circle cx="12" cy="5" r="2"></circle>
                    <path d="M12 7v4"></path>
                </svg>
            </span>
            <span>Asistente ProUDEC</span>
        </div>
    @endif
    <div class="proudec-chatbot__bubble-content">{{ $text }}</div>
</article>
