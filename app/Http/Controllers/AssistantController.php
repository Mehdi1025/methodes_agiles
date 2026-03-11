<?php

namespace App\Http\Controllers;

use App\Services\OllamaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssistantController extends Controller
{
    public function __construct(
        protected OllamaService $ollamaService
    ) {}

    /**
     * Affiche l'interface de chat de l'assistant IA.
     */
    public function index(): View
    {
        return view('assistant.index');
    }

    /**
     * Traite le message du chat et retourne la réponse de l'IA en JSON.
     */
    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $message = $validated['message'];

        $answer = $this->ollamaService->ask($message);

        return response()->json([
            'reply' => $answer,
        ]);
    }
}
