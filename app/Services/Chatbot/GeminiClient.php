<?php

namespace App\Services\Chatbot;

use App\Services\Chatbot\Exceptions\ChatbotRateLimitedException;
use App\Services\Chatbot\Exceptions\ChatbotUnavailableException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

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

        $model = (string) config('chatbot.model');
        $baseUrl = (string) config('chatbot.base_url');
        $url = rtrim($baseUrl, '/').'/models/'.$model.':generateContent';

        $payload = [
            'system_instruction' => $prompt['system_instruction'],
            'contents' => $prompt['contents'],
            'generationConfig' => [
                'temperature' => (float) config('chatbot.temperature'),
                'maxOutputTokens' => (int) config('chatbot.max_output_tokens'),
            ],
        ];

        $response = $this->send($url, $payload, $apiKey);

        if ($response->serverError()) {
            $response = $this->send($url, $payload, $apiKey);
        }

        if ($response->status() === 429) {
            throw new ChatbotRateLimitedException('Gemini quota exceeded.');
        }

        if ($response->failed()) {
            \Illuminate\Support\Facades\Log::error('Gemini request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new ChatbotUnavailableException('Gemini request failed.');
        }

        $json = $response->json();

        if (! is_array($json)) {
            throw new ChatbotUnavailableException('Gemini returned unexpected JSON.');
        }

        $text = data_get($json, 'candidates.0.content.parts.0.text');

        if (! is_string($text) || trim($text) === '') {
            throw new ChatbotUnavailableException('Gemini returned an empty reply.');
        }

        return trim($text);
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
