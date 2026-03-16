<?php

namespace App\Http\Controllers;

use App\Models\Colis;
use App\Models\User;
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
     * Injecte le contexte temps réel de l'entrepôt pour éviter les hallucinations.
     */
    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $message = $validated['message'];

        // 1. Récupération des données en temps réel (Context Injection)
        $totalColis = Colis::count();
        $colisEnStock = Colis::whereIn('statut', ['en_stock', 'reçu'])->count();
        $colisEnExpedition = Colis::where('statut', 'en_expédition')->count();
        $colisLivres = Colis::where('statut', 'livré')->count();
        $colisRetour = Colis::where('statut', 'retour')->count();
        $employesActifs = User::count();

        // 2. System Prompt dynamique (Le Cerveau de l'IA)
        $systemPrompt = "Tu es 'LogisBot', l'assistant IA expert de notre WMS (Warehouse Management System).

RÈGLES STRICTES :
- Sois concis, professionnel et direct.
- Si on te dit bonjour, salue poliment et propose ton aide. N'invente pas de questions.
- Si la question n'a aucun rapport avec la logistique ou l'entrepôt, refuse poliment de répondre.

Voici les DONNÉES EN TEMPS RÉEL de la base de données de l'entrepôt à cet instant précis :
- Nombre total de colis dans le système : {$totalColis}
- Colis actuellement en stock / en attente (reçu ou en_stock) : {$colisEnStock}
- Colis en cours d'expédition : {$colisEnExpedition}
- Colis livrés : {$colisLivres}
- Colis en retour : {$colisRetour}
- Nombre d'employés / magasiniers : {$employesActifs}

Utilise ces données UNIQUEMENT si la question de l'utilisateur le nécessite. Ne récite pas ces chiffres s'il dit juste 'bonjour'.";

        $answer = $this->ollamaService->ask($message, systemPrompt: $systemPrompt);

        return response()->json([
            'reply' => $answer,
        ]);
    }
}
