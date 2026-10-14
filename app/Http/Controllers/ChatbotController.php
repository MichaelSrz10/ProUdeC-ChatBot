<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatbotMessageRequest;
use App\Services\Chatbot\ConversationMemory;
use App\Services\Chatbot\Exceptions\ChatbotRateLimitedException;
use App\Services\Chatbot\Exceptions\ChatbotUnavailableException;
use App\Services\Chatbot\GeminiClient;
use App\Services\Chatbot\InputGuard;
use App\Services\Chatbot\KnowledgeBase;
use App\Services\Chatbot\PromptBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function store(
        ChatbotMessageRequest $request,
        InputGuard $inputGuard,
        ConversationMemory $memory,
        KnowledgeBase $knowledgeBase,
        PromptBuilder $promptBuilder,
        GeminiClient $geminiClient,
    ): JsonResponse {
        if (! config('chatbot.enabled')) {
            abort(404);
        }

        $started = microtime(true);
        $message = (string) $request->validated('message');
        $language = $promptBuilder->detectLanguage($message);

        $inspection = $inputGuard->inspect($message);

        if ($inspection['rejected']) {
            $reply = $promptBuilder->standardRejection($language);
            $this->logOutcome('rejected', $language, $started);

            return response()->json([
                'reply' => $reply,
                'status' => 'rejected',
                'language' => $language === 'mixed' ? 'es' : $language,
            ]);
        }

        try {
            $knowledge = $knowledgeBase->contextFor($language);
            $prompt = $promptBuilder->build($message, $memory->turns(), $knowledge, $language);
            $reply = $geminiClient->generate($prompt);
            $memory->push($message, $reply);
            $this->logOutcome('answered', $language, $started);

            return response()->json([
                'reply' => $reply,
                'status' => 'answered',
                'language' => $language === 'mixed' ? 'es' : $language,
            ]);
        } catch (ChatbotRateLimitedException) {
            $this->logOutcome('error', $language, $started);
            $reply = $language === 'en'
                ? 'The assistant is receiving too many requests. Please wait a minute and try again.'
                : 'El asistente está recibiendo demasiadas solicitudes. Espera un minuto e inténtalo de nuevo.';

            return response()->json([
                'reply' => $reply,
                'status' => 'rate_limited',
                'language' => $language === 'mixed' ? 'es' : $language,
            ], 429);
        } catch (ChatbotUnavailableException $e) {
            Log::error('Chatbot error: ' . $e->getMessage(), ['exception' => $e]);
            $this->logOutcome('error', $language, $started);

            return response()->json([
                'reply' => $promptBuilder->unavailableMessage($language),
                'status' => 'unavailable',
                'reason' => $e->getMessage(),
                'language' => $language === 'mixed' ? 'es' : $language,
            ], 503);
        }
    }

    public function reset(ConversationMemory $memory): JsonResponse
    {
        if (! config('chatbot.enabled')) {
            abort(404);
        }

        $memory->clear();

        return response()->json([
            'status' => 'reset',
        ]);
    }

    private function logOutcome(string $outcome, string $language, float $started): void
    {
        Log::channel('chatbot')->info('chatbot.request', [
            'outcome' => $outcome,
            'language' => $language,
            'latency_ms' => (int) round((microtime(true) - $started) * 1000),
        ]);
    }
}
