<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotProxyController extends Controller
{
    public function handle(Request $request)
        {
            $validated = $request->validate([
                'message' => 'required|string',
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama3-70b-8192',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are now identified as Eatwise Chatbot.
                        You are a helpful assistant that provides information about recipes. You can answer 
                        questions about ingredients, cooking methods, and recipe suggestions based on user preferences. 
                        If user asks for a recipe, provide a detailed recipe with ingredients and steps. If user asks for 
                        a specific type of recipe, provide a recipe that matches the request. However, if the user asks for anything
                        unrelated to recipes, politely inform them that you can only assist with recipe-related queries.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $validated['message']
                    ],
                ],
            ]);

            return response()->json($response->json(), $response->status());
        }

}
