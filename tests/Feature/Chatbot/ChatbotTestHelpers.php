<?php

namespace Tests\Feature\Chatbot;

use Illuminate\Support\Facades\Http;

trait ChatbotTestHelpers
{
    /**
     * @param  array<string, mixed>  $overrides
     */
    protected function fakeGeminiReply(string $text = 'ProUDEC es una plataforma de la Universidad de Cundinamarca.', array $overrides = []): void
    {
        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response(array_merge([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [['text' => $text]],
                        ],
                    ],
                ],
            ], $overrides), 200),
        ]);
    }
}
