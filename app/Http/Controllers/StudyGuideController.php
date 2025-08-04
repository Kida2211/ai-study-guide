<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StudyGuideController extends Controller
{
    public function index()
    {
        return view('study_form');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'notes' => 'required|string',
            'type' => 'required|in:summary,quiz',
        ]);

        $type = $request->input('type');
        $notes = $request->input('notes');

        $instruction = $type === 'summary'
            ? "Summarize the following study notes:"
            : "Generate quiz questions based on the following notes:";

        $response = Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful study assistant.'],
                ['role' => 'user', 'content' => "{$instruction}\n\n{$notes}"],
            ],
        ]);

        $output = $response->json()['choices'][0]['message']['content'] ?? 'Something went wrong.';

        return redirect('/')->with('output', $output);
    }
}
