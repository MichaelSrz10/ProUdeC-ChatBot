<?php

namespace Tests\Feature\Chatbot;

use App\Services\Chatbot\PromptBuilder;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ChatbotBilingualTest extends TestCase
{
    use ChatbotTestHelpers;

    public function test_prompt_includes_language_rule_and_detected_language(): void
    {
        $this->fakeGeminiReply('ProUDEC is a platform.');

        $this->postJson(route('chatbot.message'), ['message' => 'What can teachers do in ProUDEC?'])->assertOk();

        Http::assertSent(function ($request) {
            $system = data_get($request->data(), 'system_instruction.parts.0.text', '');

            return str_contains($system, 'Reglas de idioma')
                && str_contains($system, 'Idioma detectado de esta petición: en');
        });
    }

    public function test_spanish_message_marks_language_as_es(): void
    {
        $this->fakeGeminiReply();

        $this->postJson(route('chatbot.message'), ['message' => '¿Qué es ProUDEC?'])
            ->assertOk()
            ->assertJsonPath('language', 'es');
    }

    public function test_mixed_message_is_detected(): void
    {
        $builder = new PromptBuilder;

        $this->assertSame('mixed', $builder->detectLanguage('¿Qué es ProUDEC and what features does it have?'));
    }
}
