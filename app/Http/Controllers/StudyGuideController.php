<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

        $notes = $request->input('notes');
        $type = $request->input('type');

        $instruction = $type === 'summary'
            ? "You are a helpful study assistant. Summarize the following study notes into clear bullet points:"
            : "You are a test prep expert. Create 5 multiple-choice quiz questions based on the following notes. Include answer choices and mark the correct answer.";

        try {
            $response = Http::withToken(env('OPENAI_API_KEY'))->post(env('OPENAI_API_URL') . '/chat/completions', [

                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => "{$instruction}\n\n{$notes}"],
                ],
            ]);

            if ($response->failed()) {
                Log::error('OpenAI API failed', ['response' => $response->body()]);
                $output = 'OpenAI API returned an error. Please check your API key or try again later.';
            } else {
                $output = $response->json()['choices'][0]['message']['content'] ?? 'OpenAI did not return content.';
            }
        } catch (\Exception $e) {
            Log::error('OpenAI request exception', ['error' => $e->getMessage()]);
            $output = 'Error connecting to OpenAI: ' . $e->getMessage();
        }

        return redirect('/')->with('output', $output);
    }
}
