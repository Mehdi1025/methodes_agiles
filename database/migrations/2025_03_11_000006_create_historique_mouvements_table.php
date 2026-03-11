<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('historique_mouvements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('colis_id')->constrained('colis')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('ancien_statut', ['reçu', 'en_stock', 'en_expédition', 'livré', 'retour'])->nullable();
            $table->enum('nouveau_statut', ['reçu', 'en_stock', 'en_expédition', 'livré', 'retour']);
            $table->timestamp('date_mouvement')->useCurrent();
            $table->text('commentaire')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historique_mouvements');
    }
};
