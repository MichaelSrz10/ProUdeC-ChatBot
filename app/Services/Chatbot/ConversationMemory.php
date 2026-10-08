<?php

namespace App\Services\Chatbot;

use Illuminate\Contracts\Session\Session;

class ConversationMemory
{
    public const SESSION_KEY = 'chatbot.turns';

    public function __construct(private Session $session) {}

    /**
     * @return list<array{role: string, text: string}>
     */
    public function turns(): array
    {
        $turns = $this->session->get(self::SESSION_KEY, []);

        return is_array($turns) ? array_values($turns) : [];
    }

    public function push(string $userText, string $assistantText): void
    {
        $turns = $this->turns();
        $turns[] = ['role' => 'user', 'text' => $userText];
        $turns[] = ['role' => 'model', 'text' => $assistantText];

        $maxTurns = max(1, (int) config('chatbot.history_turns', 6));
        $maxMessages = $maxTurns * 2;

        if (count($turns) > $maxMessages) {
            $turns = array_slice($turns, -$maxMessages);
        }

        $this->session->put(self::SESSION_KEY, $turns);
    }

    public function clear(): void
    {
        $this->session->forget(self::SESSION_KEY);
    }
}
