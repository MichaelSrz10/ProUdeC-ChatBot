<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatbotMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        $max = (int) config('chatbot.max_input_chars', 500);

        return [
            'message' => ['required', 'string', 'max:'.$max],
        ];
    }
}
