<?php

namespace Tests\Feature\Chatbot;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ChatbotEndpointTest extends TestCase
{
    use ChatbotTestHelpers;
    use RefreshDatabase;

    public function test_authenticated_and_guest_users_receive_json_reply(): void
    {
        $this->fakeGeminiReply();

        $guest = $this->postJson(route('chatbot.message'), ['message' => '¿Qué es ProUDEC?']);
        $guest->assertOk()->assertJsonStructure(['reply', 'status', 'language']);

        $user = User::factory()->create();
        $auth = $this->actingAs($user)->postJson(route('chatbot.message'), ['message' => '¿Qué es ProUDEC?']);
        $auth->assertOk()->assertJsonPath('status', 'answered');
    }

    public function test_message_is_required(): void
    {
        $this->postJson(route('chatbot.message'), [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['message']);
    }

    public function test_message_cannot_exceed_max_length(): void
    {
        config(['chatbot.max_input_chars' => 20]);

        $this->postJson(route('chatbot.message'), ['message' => str_repeat('a', 21)])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['message']);
    }

    public function test_route_uses_web_middleware_for_csrf(): void
    {
        $route = Route::getRoutes()->getByName('chatbot.message');

        $this->assertNotNull($route);
        $this->assertContains('web', $route->gatherMiddleware());
        $this->assertContains('throttle:chatbot', $route->gatherMiddleware());
    }

    public function test_disabled_chatbot_returns_not_found(): void
    {
        config(['chatbot.enabled' => false]);

        $this->postJson(route('chatbot.message'), ['message' => 'Hola'])
            ->assertNotFound();
    }

    public function test_public_page_includes_widget_when_enabled(): void
    {
        $this->get('/')->assertOk()->assertSee('proudec-chatbot', false);
    }

    public function test_rate_limit_returns_429(): void
    {
        $this->fakeGeminiReply();
        config(['chatbot.rate_limit_guest_per_minute' => 1]);
        RateLimiter::clear('chatbot-guest:127.0.0.1');

        $this->postJson(route('chatbot.message'), ['message' => '¿Qué es ProUDEC?'])->assertOk();
        $this->postJson(route('chatbot.message'), ['message' => '¿Qué es ProUDEC?'])->assertStatus(429);
    }
}
