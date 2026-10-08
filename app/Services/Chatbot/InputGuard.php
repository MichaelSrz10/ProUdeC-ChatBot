<?php

namespace App\Services\Chatbot;

class InputGuard
{
    /**
     * @var list<string>
     */
    private array $injectionPatterns = [
        '/ignore\s+(all\s+)?(previous|prior|above)\s+instructions/i',
        '/ignora\s+(todas\s+)?(tus\s+)?instrucciones/i',
        '/ignore\s+your\s+instructions/i',
        '/(show|reveal|print|dump|display)\s+(me\s+)?(your\s+|the\s+)?(system\s+)?prompt/i',
        '/muestra(me)?\s+(tu\s+|el\s+)?prompt/i',
        '/revela\s+(tu\s+|el\s+)?prompt/i',
        '/jailbreak/i',
        '/\bdan\s+mode\b/i',
        '/developer\s+mode/i',
        '/you\s+are\s+now\s+(a|an|my)\b/i',
        '/act\s+as\s+(the\s+)?system/i',
        '/override\s+(the\s+)?(system|rules|guardrails)/i',
    ];

    /**
     * @return array{rejected: bool, reason: string|null}
     */
    public function inspect(string $message): array
    {
        $trimmed = trim($message);

        if ($trimmed === '') {
            return ['rejected' => true, 'reason' => 'empty'];
        }

        $max = (int) config('chatbot.max_input_chars', 500);

        if (mb_strlen($trimmed) > $max) {
            return ['rejected' => true, 'reason' => 'too_long'];
        }

        $withoutSymbols = preg_replace('/[\p{So}\p{Sk}\p{P}\p{S}\s]+/u', '', $trimmed) ?? '';

        if ($withoutSymbols === '') {
            return ['rejected' => true, 'reason' => 'no_text'];
        }

        foreach ($this->injectionPatterns as $pattern) {
            if (preg_match($pattern, $trimmed) === 1) {
                return ['rejected' => true, 'reason' => 'injection'];
            }
        }

        return ['rejected' => false, 'reason' => null];
    }
}
