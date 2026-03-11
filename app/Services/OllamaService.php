<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OllamaService
{
    protected string $baseUrl = 'http://127.0.0.1:11434';

    protected string $model = 'mistral';

    protected string $systemPrompt = 'Tu es un assistant logistique expert. Tu dois IMPÉRATIVEMENT répondre en FRANÇAIS. Tes réponses doivent être chirurgicales, concises et ultra-courtes (2 phrases maximum). Ne fais jamais de longues listes.';

    /**
     * Envoie une question à l'IA Ollama et retourne la réponse.
     *
     * @param  array<string, mixed>  $context
     */
    public function ask(string $prompt, array $context = []): string
    {
        set_time_limit(300);

        $fullPrompt = $this->buildPrompt($prompt, $context);

        try {
            $response = Http::timeout(300)
                ->post("{$this->baseUrl}/api/generate", [
                    'model' => $this->model,
                    'prompt' => $fullPrompt,
                    'system' => $this->systemPrompt,
                    'stream' => false,
                    'options' => [
                        'num_predict' => 100,
                        'temperature' => 0.2,
                        'top_k' => 40,
                    ],
                ]);

            if (! $response->successful()) {
                Log::warning('Ollama API error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return "L'IA est actuellement déconnectée. Vérifiez qu'Ollama est bien lancé sur votre machine (ollama serve) et que le modèle mistral est installé (ollama pull mistral).";
            }

            $data = $response->json();
            $answer = $data['response'] ?? '';

            return trim($answer) ?: "Je n'ai pas pu générer de réponse. Réessayez avec une question plus précise.";
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Ollama connection failed', ['message' => $e->getMessage()]);

            return "L'IA est actuellement déconnectée. Assurez-vous qu'Ollama est lancé sur votre machine (ollama serve).";
        } catch (\Exception $e) {
            Log::error('Ollama error', ['message' => $e->getMessage()]);

            return "La requête a expiré ou une erreur est survenue. L'IA peut prendre jusqu'à 5 minutes pour répondre sur une machine lente. Veuillez réessayer.";
        }
    }

    /**
     * Construit le prompt final avec le contexte optionnel.
     *
     * @param  array<string, mixed>  $context
     */
    protected function buildPrompt(string $prompt, array $context): string
    {
        if (empty($context)) {
            return $prompt;
        }

        $contextStr = collect($context)
            ->map(fn ($value, $key) => "{$key}: {$value}")
            ->implode("\n");

        return "Contexte actuel de l'entrepôt:\n{$contextStr}\n\nQuestion: {$prompt}";
    }
}
