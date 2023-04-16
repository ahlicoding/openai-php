<?php

namespace App\Http\Controllers;

use App\Libraries\OpenAI;
use Illuminate\Http\Request;

class OpenAIController extends Controller
{
    public function index()
    {
        return view('openai');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:255',
        ]);

        $openai = new OpenAI;
        $prompt = $request->input('prompt');
        $response = $openai->sendPrompt($prompt);

        return view('openai', compact('response'));
    }


    public function chat(Request $request)
    {
        $message = $request->input('message');
        $model = $request->input('model');
        $token = $request->input('token');

        $model = 'gpt-3.5-turbo';
        $token = 70;

        $prompt = [
            'input' => $message,
            'temperature' => 0.7,
            'max_tokens' => $token,
            'top_p' => 1,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
        ];

        $openai = new OpenAI(env('OPENAI_SECRET_KEY'));
        $response = $openai->sendPrompt($prompt);

        //$answer = $response['choices'][0]['text'];

        return response()->json(['answer' => $response]);
    }


}
