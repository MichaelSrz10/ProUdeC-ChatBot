<?php

namespace Tests\Unit\Chatbot;

use App\Services\Chatbot\GeminiClient;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GeminiClientTest extends TestCase
{
    public function test_falls_back_to_secondary_model_when_primary_fails(): void
    {
        config([
            'chatbot.api_key' => 'test-key',
            'chatbot.model' => 'primary-model',
            'chatbot.fallback_models' => ['fallback-model'],
        ]);

        Http::fake([
            '*/models/primary-model:generateContent' => Http::response([
                'error' => [
                    'code' => 503,
                    'message' => 'This model is currently experiencing high demand.',
                ],
            ], 503),
            '*/models/fallback-model:generateContent' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [['text' => 'Respuesta desde el modelo de respaldo.']],
                        ],
                    ],
                ],
            ], 200),
        ]);

        $client = new GeminiClient;
        $reply = $client->generate([
            'system_instruction' => ['parts' => [['text' => 'system']]],
            'contents' => [['role' => 'user', 'parts' => [['text' => 'user']]]],
        ]);

        $this->assertSame('Respuesta desde el modelo de respaldo.', $reply);
    }
}
