import { initChatbot } from './ui';

function boot() {
    const root = document.getElementById('proudec-chatbot');
    if (root) {
        initChatbot(root);
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
} else {
    boot();
}
