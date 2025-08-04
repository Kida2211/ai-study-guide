<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    public function generateContent(string $notes, string $type = 'summary'): string
    {
        $instruction = $type === 'summary'
            ? "You are a college tutor. Summarize these notes into clear bullet points:"
            : "You are a test prep expert. Create 5 quiz questions (multiple choice, 4 options, correct answer) based on:";

        $response = Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $instruction . "\n\n" . $notes],
            ],
        ]);

        return $response->json()['choices'][0]['message']['content'] ?? 'Failed to generate AI content.';
    }
}
