<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE colis MODIFY COLUMN statut ENUM('reçu', 'en_stock', 'en_preparation', 'en_expédition', 'livré', 'retour') DEFAULT 'reçu'");
        DB::statement("ALTER TABLE historique_mouvements MODIFY COLUMN ancien_statut ENUM('reçu', 'en_stock', 'en_preparation', 'en_expédition', 'livré', 'retour') NULL");
        DB::statement("ALTER TABLE historique_mouvements MODIFY COLUMN nouveau_statut ENUM('reçu', 'en_stock', 'en_preparation', 'en_expédition', 'livré', 'retour') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE colis MODIFY COLUMN statut ENUM('reçu', 'en_stock', 'en_expédition', 'livré', 'retour') DEFAULT 'reçu'");
        DB::statement("ALTER TABLE historique_mouvements MODIFY COLUMN ancien_statut ENUM('reçu', 'en_stock', 'en_expédition', 'livré', 'retour') NULL");
        DB::statement("ALTER TABLE historique_mouvements MODIFY COLUMN nouveau_statut ENUM('reçu', 'en_stock', 'en_expédition', 'livré', 'retour') NOT NULL");
    }
};
