<?php

namespace Tests\Feature\Chatbot;

use App\Services\Chatbot\PromptBuilder;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ChatbotDomainRestrictionTest extends TestCase
{
    use ChatbotTestHelpers;

    public function test_prompt_contains_closed_domain_and_knowledge_block(): void
    {
        $this->fakeGeminiReply();

        $this->postJson(route('chatbot.message'), ['message' => '¿Qué es ProUDEC?'])->assertOk();

        Http::assertSent(function ($request) {
            $body = $request->data();
            $system = data_get($body, 'system_instruction.parts.0.text', '');

            return str_contains($system, 'Dominio cerrado')
                && str_contains($system, '<conocimiento>')
                && str_contains($system, '</conocimiento>')
                && str_contains($system, 'ProUDEC');
        });
    }

    public function test_off_topic_simulated_reply_uses_standard_rejection_in_prompt_examples(): void
    {
        $builder = new PromptBuilder;
        $instruction = $builder->systemInstruction('bloque', 'es');

        $this->assertStringContainsString(PromptBuilder::REJECTION_ES, $instruction);
        $this->assertStringContainsString(PromptBuilder::REJECTION_EN, $instruction);
        $this->assertStringContainsString('¿Quién ganó el mundial?', $instruction);
    }

    public function test_simulated_off_topic_response_is_returned_as_json(): void
    {
        $this->fakeGeminiReply(PromptBuilder::REJECTION_ES);

        $this->postJson(route('chatbot.message'), ['message' => '¿Quién ganó el mundial?'])
            ->assertOk()
            ->assertJsonPath('reply', PromptBuilder::REJECTION_ES);
    }
}
