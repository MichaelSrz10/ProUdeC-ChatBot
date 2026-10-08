<?php

namespace Tests\Feature\Chatbot;

use App\Services\Chatbot\PromptBuilder;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ChatbotFailureTest extends TestCase
{
    public function test_missing_api_key_returns_friendly_unavailable_message(): void
    {
        config(['chatbot.api_key' => '']);
        Http::fake();

        $response = $this->postJson(route('chatbot.message'), ['message' => '¿Qué es ProUDEC?']);

        $response->assertStatus(503)
            ->assertJsonPath('status', 'unavailable')
            ->assertJsonPath('reply', PromptBuilder::UNAVAILABLE_ES)
            ->assertJsonMissingPath('exception');
        Http::assertNothingSent();
    }

    public function test_timeout_returns_friendly_message(): void
    {
        Http::fake(fn () => throw new ConnectionException('timeout'));

        $this->postJson(route('chatbot.message'), ['message' => '¿Qué es ProUDEC?'])
            ->assertStatus(503)
            ->assertJsonPath('status', 'unavailable');
    }

    public function test_server_error_returns_friendly_message(): void
    {
        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response(['error' => 'server'], 500),
        ]);

        $this->postJson(route('chatbot.message'), ['message' => '¿Qué es ProUDEC?'])
            ->assertStatus(503)
            ->assertJsonPath('status', 'unavailable');
    }

    public function test_gemini_429_returns_rate_limited_json(): void
    {
        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response(['error' => 'quota'], 429),
        ]);

        $this->postJson(route('chatbot.message'), ['message' => '¿Qué es ProUDEC?'])
            ->assertStatus(429)
            ->assertJsonPath('status', 'rate_limited');
    }

    public function test_empty_model_text_is_handled(): void
    {
        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [['content' => ['parts' => [['text' => '   ']]]]],
            ], 200),
        ]);

        $this->postJson(route('chatbot.message'), ['message' => '¿Qué es ProUDEC?'])
            ->assertStatus(503)
            ->assertJsonPath('status', 'unavailable');
    }

    public function test_unexpected_json_is_handled(): void
    {
        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response(['foo' => 'bar'], 200),
        ]);

        $this->postJson(route('chatbot.message'), ['message' => '¿Qué es ProUDEC?'])
            ->assertStatus(503)
            ->assertJsonPath('status', 'unavailable');
    }
}
