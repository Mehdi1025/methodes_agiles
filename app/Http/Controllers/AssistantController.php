<?php

namespace App\Http\Controllers;

use App\Models\Colis;
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
     * Routeur d'intentions : intercepte les requêtes courantes en PHP,
     * n'appelle Ollama que pour les questions non routées.
     */
    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $question = trim($validated['message']);
        $questionLower = mb_strtolower($question);

        // ─── 1. Récupération des variables ───────────────────────────────────
        $total = Colis::count();
        $stock = Colis::whereIn('statut', ['en_stock', 'reçu'])->count();
        $expedies = Colis::where('statut', 'en_expédition')->count();
        $livres = Colis::where('statut', 'livré')->count();
        $retours = Colis::where('statut', 'retour')->count();

        // ─── INTERCEPTION 1 : Salutations ──────────────────────────────────────
        if (preg_match('/\b(bonjour|salut|hello|hi|hey|coucou)\b/i', $questionLower)) {
            return response()->json([
                'reply' => "Bonjour. L'entrepôt compte actuellement {$total} colis, dont {$expedies} en cours d'expédition.",
            ]);
        }

        // ─── INTERCEPTION 2 : Statistiques ─────────────────────────────────────
        if (preg_match('/\b(combien|statistiques|chiffres|stock|total|état|etat)\b/i', $questionLower)) {
            return response()->json([
                'reply' => "Voici l'état des flux : {$total} colis gérés, {$stock} en stock, {$expedies} en expédition et {$livres} livrés.",
            ]);
        }

        // ─── INTERCEPTION 3 : Hors-sujet ───────────────────────────────────────
        if (preg_match('/\b(naissance|âge|age|qui|blague|créateur|creeur|météo|meteo|vie privée|vie privee)\b/i', $questionLower)) {
            return response()->json([
                'reply' => "Je suis LogisBot, l'assistant logistique de cet entrepôt. Je ne réponds qu'aux requêtes professionnelles.",
            ]);
        }

        // ─── APPEL OLLAMA (aucune interception) ─────────────────────────────────
        $stats = [
            'total' => $total,
            'stock' => $stock,
            'expedies' => $expedies,
            'livres' => $livres,
            'retours' => $retours,
        ];

        $answer = $this->ollamaService->chat($question, $stats);

        return response()->json([
            'reply' => $answer,
        ]);
    }
}
