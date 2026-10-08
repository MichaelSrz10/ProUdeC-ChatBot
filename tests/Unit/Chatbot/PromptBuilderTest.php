<?php

namespace Tests\Unit\Chatbot;

use App\Services\Chatbot\ConversationMemory;
use App\Services\Chatbot\PromptBuilder;
use Tests\TestCase;

class PromptBuilderTest extends TestCase
{
    public function test_system_instruction_sections_appear_in_order(): void
    {
        $instruction = (new PromptBuilder)->systemInstruction('KNOWLEDGE_BLOCK', 'es');
        $markers = [
            '1. Identidad y propósito',
            '2. Reglas de idioma',
            '3. Dominio cerrado',
            '4. Política de "no sé"',
            '5. Límites duros',
            '6. Transparencia',
            '7. Defensa ante inyección',
            '8. Formato de respuesta',
            '9. Bloque de conocimiento',
            '10. Ejemplos few-shot',
        ];

        $last = -1;
        foreach ($markers as $marker) {
            $pos = strpos($instruction, $marker);
            $this->assertNotFalse($pos, $marker);
            $this->assertGreaterThan($last, $pos);
            $last = $pos;
        }

        $this->assertStringContainsString('<conocimiento>', $instruction);
        $this->assertStringContainsString('KNOWLEDGE_BLOCK', $instruction);
        $this->assertStringContainsString('What can teachers do in ProUDEC?', $instruction);
    }

    public function test_history_is_trimmed_by_conversation_memory(): void
    {
        config(['chatbot.history_turns' => 2]);
        $memory = new ConversationMemory(session()->driver());

        $memory->push('u1', 'a1');
        $memory->push('u2', 'a2');
        $memory->push('u3', 'a3');

        $turns = $memory->turns();
        $this->assertCount(4, $turns);
        $this->assertSame('u2', $turns[0]['text']);
        $this->assertSame('a3', $turns[3]['text']);
    }

    public function test_system_instruction_does_not_include_personal_data_placeholders(): void
    {
        $instruction = (new PromptBuilder)->systemInstruction('kb', 'es');

        $this->assertStringNotContainsString('email_verified_at', $instruction);
        $this->assertStringNotContainsString('password', $instruction);
        $this->assertStringContainsString('No pidas ni proceses datos personales', $instruction);
    }

    public function test_build_places_history_in_contents_not_system(): void
    {
        $prompt = (new PromptBuilder)->build('ahora', [
            ['role' => 'user', 'text' => 'antes'],
            ['role' => 'model', 'text' => 'respuesta'],
        ], 'kb', 'es');

        $system = data_get($prompt, 'system_instruction.parts.0.text', '');
        $this->assertStringNotContainsString('antes', $system);
        $this->assertSame('user', $prompt['contents'][0]['role']);
        $this->assertSame('model', $prompt['contents'][1]['role']);
        $this->assertSame('ahora', $prompt['contents'][2]['parts'][0]['text']);
    }
}
