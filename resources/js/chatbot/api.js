function csrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    const root = document.getElementById('proudec-chatbot');

    return meta?.getAttribute('content') || root?.dataset.csrf || '';
}

async function parseJson(response) {
    try {
        return await response.json();
    } catch {
        return {};
    }
}

export async function sendMessage(message) {
    const response = await fetch('/chatbot/message', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            'X-CSRF-TOKEN': csrfToken(),
            'X-Requested-With': 'XMLHttpRequest',
        },
        credentials: 'same-origin',
        body: JSON.stringify({ message }),
    });

    const data = await parseJson(response);

    return { ok: response.ok, status: response.status, data };
}

export async function resetConversation() {
    const response = await fetch('/chatbot/reset', {
        method: 'POST',
        headers: {
            Accept: 'application/json',
            'X-CSRF-TOKEN': csrfToken(),
            'X-Requested-With': 'XMLHttpRequest',
        },
        credentials: 'same-origin',
    });

    return { ok: response.ok, status: response.status };
}
