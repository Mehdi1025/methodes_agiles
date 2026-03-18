<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OllamaService
{
    protected string $baseUrl;

    protected string $model;

    public function __construct()
    {
        $this->baseUrl = config('services.ollama.url', 'http://host.docker.internal:11434');
        $this->model = config('services.ollama.model', 'llama3.2:1b');
    }

    /**
     * Appelle l'API Chat d'Ollama et retourne la réponse.
     *
     * @param  array{total: int, stock: int, expedies: int, livres: int, retours: int}  $stats
     */
    public function chat(string $question, array $stats): string
    {
        set_time_limit(300);

        $total = $stats['total'] ?? 0;
        $stock = $stats['stock'] ?? 0;
        $expedies = $stats['expedies'] ?? 0;
        $livres = $stats['livres'] ?? 0;
        $retours = $stats['retours'] ?? 0;

        $systemContent = "Tu es LogisBot, un expert en logistique d'entrepôt. Tu réponds de manière très concise, professionnelle, et EXCLUSIVEMENT en français. Voici les données actuelles de l'entrepôt : Total {$total} colis, {$stock} en stock, {$expedies} en expédition, {$livres} livrés, {$retours} retours.";

        try {
            $response = Http::timeout(20)
                ->post("{$this->baseUrl}/api/chat", [
                    'model' => $this->model,
                    'stream' => false,
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $systemContent,
                        ],
                        [
                            'role' => 'user',
                            'content' => $question,
                        ],
                    ],
                ]);

            if (! $response->successful()) {
                Log::warning('Ollama API error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return "L'IA est actuellement déconnectée. Vérifiez qu'Ollama est bien lancé (ollama serve) et que le modèle est installé (ollama pull {$this->model}).";
            }

            $data = $response->json();
            $content = $data['message']['content'] ?? '';

            return trim($content) ?: "Je n'ai pas pu générer de réponse. Réessayez avec une question plus précise.";
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Ollama connection failed', ['message' => $e->getMessage()]);

            return "LogisBot est en train de scanner l'entrepôt, réessayez dans un instant.";
        } catch (\Exception $e) {
            Log::error('Ollama error', ['message' => $e->getMessage()]);

            return "LogisBot est en train de scanner l'entrepôt, réessayez dans un instant.";
        }
    }
}
