<?php

return [

    'enabled' => (bool) env('CHATBOT_ENABLED', true),

    'api_key' => env('GEMINI_API_KEY'),

    'model' => env('GEMINI_MODEL', 'gemini-3.8-flash'),

    'base_url' => env('GEMINI_BASE_URL', 'https://generativelanguage.googleapis.com/v1beta'),

    'timeout_seconds' => (int) env('CHATBOT_TIMEOUT_SECONDS', 20),

    'max_input_chars' => (int) env('CHATBOT_MAX_INPUT_CHARS', 500),

    'history_turns' => (int) env('CHATBOT_HISTORY_TURNS', 6),

    'rate_limit_auth_per_minute' => (int) env('CHATBOT_RATE_LIMIT_AUTH_PER_MINUTE', 10),

    'rate_limit_guest_per_minute' => (int) env('CHATBOT_RATE_LIMIT_GUEST_PER_MINUTE', 5),

    'knowledge_path' => resource_path('knowledge'),

    'temperature' => 0.25,

    'max_output_tokens' => 1024,

    /*
    | Approximate character budget for the stuffed knowledge block.
    | Gemini 2.5 Flash has a large context window; this cap keeps prompts auditable.
    */
    'max_context_chars' => 48000,

];
