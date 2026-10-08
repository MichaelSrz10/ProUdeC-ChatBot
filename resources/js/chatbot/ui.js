import { sendMessage, resetConversation } from './api';
import { interfaceLanguage, labels } from './i18n';

function renderPlain(text) {
    const fragment = document.createDocumentFragment();
    const lines = String(text).split('\n');

    lines.forEach((line, index) => {
        fragment.appendChild(document.createTextNode(line));
        if (index < lines.length - 1) {
            fragment.appendChild(document.createElement('br'));
        }
    });

    return fragment;
}

export function initChatbot(root) {
    if (!root) {
        return;
    }

    const lang = interfaceLanguage();
    const t = labels[lang];
    const panel = root.querySelector('[data-chatbot-panel]');
    const launcher = root.querySelector('[data-chatbot-launcher]');
    const closer = root.querySelector('[data-chatbot-close]');
    const form = root.querySelector('[data-chatbot-form]');
    const input = root.querySelector('[data-chatbot-input]');
    const log = root.querySelector('[data-chatbot-log]');
    const suggestions = root.querySelector('[data-chatbot-suggestions]');
    let lastMessage = '';
    let previousFocus = null;

    function setOpen(open) {
        panel.hidden = !open;
        launcher.setAttribute('aria-expanded', open ? 'true' : 'false');
        if (open) {
            previousFocus = document.activeElement;
            input.focus();
        } else if (previousFocus && typeof previousFocus.focus === 'function') {
            previousFocus.focus();
        }
    }

    function appendBubble(role, text, extra = {}) {
        const article = document.createElement('article');
        article.className = `proudec-chatbot__bubble proudec-chatbot__bubble--${role}`;

        if (role === 'assistant') {
            const author = document.createElement('div');
            author.className = 'proudec-chatbot__bubble-author';
            author.innerHTML = `
                <span class="proudec-chatbot__bubble-avatar">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="10" rx="2"></rect>
                        <circle cx="12" cy="5" r="2"></circle>
                        <path d="M12 7v4"></path>
                    </svg>
                </span>
                <span>${t.title}</span>
            `;
            article.appendChild(author);
        }

        const content = document.createElement('div');
        content.className = 'proudec-chatbot__bubble-content';

        if (extra.typing) {
            article.dataset.typing = '1';
            content.innerHTML = `
                <span class="proudec-chatbot__typing-indicator">
                    <span></span><span></span><span></span>
                </span>
            `;
        } else {
            content.appendChild(renderPlain(text));
        }
        article.appendChild(content);

        if (extra.retry) {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'proudec-chatbot__retry';
            button.innerHTML = `
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13">
                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                    <path d="M3 3v5h5"></path>
                </svg>
                <span>${t.retry}</span>
            `;
            button.addEventListener('click', () => submit(lastMessage));
            article.appendChild(button);
        }

        log.appendChild(article);
        log.scrollTop = log.scrollHeight;

        return article;
    }

    function setBusy(busy) {
        input.disabled = busy;
        const submitBtn = form.querySelector('[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = busy;
            const label = submitBtn.querySelector('[data-submit-label]');
            if (label) {
                label.textContent = busy ? t.sending : t.send;
            } else {
                submitBtn.textContent = busy ? t.sending : t.send;
            }
            submitBtn.classList.toggle('is-busy', busy);
        }
    }

    async function submit(message) {
        const trimmed = message.trim();
        if (!trimmed) {
            return;
        }

        if (suggestions) {
            suggestions.style.display = 'none';
        }

        lastMessage = trimmed;
        appendBubble('user', trimmed);
        input.value = '';
        setBusy(true);

        const typing = appendBubble('assistant', '', { typing: true });

        try {
            const result = await sendMessage(trimmed);
            typing.remove();
            const reply = result.data.reply || (result.status === 429 ? t.rateLimited : t.error);
            const retry = !result.ok && result.status !== 422;
            appendBubble('assistant', reply, { retry });
        } catch {
            typing.remove();
            appendBubble('assistant', t.error, { retry: true });
        } finally {
            setBusy(false);
            input.focus();
        }
    }

    launcher?.addEventListener('click', () => setOpen(panel.hidden));
    closer?.addEventListener('click', () => setOpen(false));

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !panel.hidden) {
            setOpen(false);
        }
    });

    form?.addEventListener('submit', (event) => {
        event.preventDefault();
        submit(input.value);
    });

    suggestions?.querySelectorAll('button').forEach((button) => {
        button.addEventListener('click', () => {
            const text = button.querySelector('span')?.textContent || button.textContent || '';
            submit(text.trim());
        });
    });

    root.querySelectorAll('[data-chatbot-reset]').forEach((btn) => {
        btn.addEventListener('click', async () => {
            await resetConversation();
            log.querySelectorAll('[data-dynamic="1"]').forEach((node) => node.remove());
            const welcome = appendBubble('assistant', t.welcome);
            welcome.dataset.dynamic = '1';
        });
    });

    log.querySelectorAll('.proudec-chatbot__bubble').forEach((node) => {
        node.dataset.dynamic = '1';
    });
}
