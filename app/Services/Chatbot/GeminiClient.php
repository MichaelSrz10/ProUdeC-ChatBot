<?php

namespace App\Services\Chatbot;

use App\Services\Chatbot\Exceptions\ChatbotRateLimitedException;
use App\Services\Chatbot\Exceptions\ChatbotUnavailableException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiClient
{
    /**
     * @param  array{system_instruction: array<string, mixed>, contents: list<array<string, mixed>>}  $prompt
     */
    public function generate(array $prompt): string
    {
        $apiKey = (string) config('chatbot.api_key', '');

        if (trim($apiKey) === '') {
            throw new ChatbotUnavailableException('API key is not configured.');
        }

        $baseUrl = (string) config('chatbot.base_url');
        $primaryModel = (string) config('chatbot.model', 'gemini-flash-lite-latest');
        $fallbackModels = (array) config('chatbot.fallback_models', ['gemini-3.5-flash-lite']);

        $models = array_values(array_unique(array_filter([
            $primaryModel,
            ...$fallbackModels,
        ])));

        $payload = [
            'system_instruction' => $prompt['system_instruction'],
            'contents' => $prompt['contents'],
            'generationConfig' => [
                'temperature' => (float) config('chatbot.temperature'),
                'maxOutputTokens' => (int) config('chatbot.max_output_tokens'),
            ],
        ];

        $rateLimited = false;
        $lastResponse = null;

        foreach ($models as $model) {
            $url = rtrim($baseUrl, '/').'/models/'.$model.':generateContent';

            $response = $this->send($url, $payload, $apiKey);

            if ($response->serverError()) {
                $response = $this->send($url, $payload, $apiKey);
            }

            if ($response->successful()) {
                $json = $response->json();

                if (is_array($json)) {
                    $text = data_get($json, 'candidates.0.content.parts.0.text');

                    if (is_string($text) && trim($text) !== '') {
                        return trim($text);
                    }
                }
            }

            if ($response->status() === 429) {
                $rateLimited = true;
            }

            Log::warning("Gemini model [{$model}] failed with status {$response->status()}, checking next candidate if available.", [
                'status' => $response->status(),
                'body' => substr($response->body(), 0, 200),
            ]);

            $lastResponse = $response;
        }

        if ($rateLimited) {
            throw new ChatbotRateLimitedException('Gemini quota exceeded.');
        }

        if ($lastResponse !== null && $lastResponse->failed()) {
            Log::error('All Gemini request attempts failed', [
                'status' => $lastResponse->status(),
                'body' => $lastResponse->body(),
            ]);
        }

        throw new ChatbotUnavailableException('Gemini request failed.');
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function send(string $url, array $payload, string $apiKey): Response
    {
        try {
            return Http::timeout((int) config('chatbot.timeout_seconds'))
                ->withHeaders([
                    'x-goog-api-key' => $apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post($url, $payload);
        } catch (ConnectionException $exception) {
            throw new ChatbotUnavailableException('Gemini connection failed.', 0, $exception);
        }
    }
}
