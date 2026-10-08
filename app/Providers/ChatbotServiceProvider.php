<?php

namespace App\Providers;

use App\Services\Chatbot\GeminiClient;
use App\Services\Chatbot\KnowledgeBase;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class ChatbotServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(KnowledgeBase::class, function () {
            return new KnowledgeBase(
                (string) config('chatbot.knowledge_path'),
                (int) config('chatbot.max_context_chars'),
            );
        });

        $this->app->singleton(GeminiClient::class);
    }

    public function boot(): void
    {
        RateLimiter::for('chatbot', function (Request $request) {
            $maxAttempts = $request->user()
                ? (int) config('chatbot.rate_limit_auth_per_minute')
                : (int) config('chatbot.rate_limit_guest_per_minute');

            $key = $request->user()
                ? 'chatbot-auth:'.$request->user()->getAuthIdentifier()
                : 'chatbot-guest:'.$request->ip();

            return Limit::perMinute($maxAttempts)->by($key)->response(function () use ($request) {
                $language = app(\App\Services\Chatbot\PromptBuilder::class)
                    ->detectLanguage((string) $request->input('message', ''));

                $reply = $language === 'en'
                    ? 'You have reached the request limit. Please wait a minute and try again.'
                    : 'Has alcanzado el límite de solicitudes. Espera un minuto e inténtalo de nuevo.';

                if ($language === 'mixed') {
                    $reply = 'Has alcanzado el límite de solicitudes. Espera un minuto. / You have reached the request limit. Please wait a minute.';
                }

                return response()->json([
                    'reply' => $reply,
                    'status' => 'rate_limited',
                    'language' => $language === 'mixed' ? 'es' : $language,
                ], 429);
            });
        });
    }
}
