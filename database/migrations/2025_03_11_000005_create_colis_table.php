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
        Schema::create('colis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code_qr', 50)->unique()->nullable();
            $table->text('description');
            $table->decimal('poids_kg', 6, 2);
            $table->string('dimensions', 50);
            $table->enum('statut', ['reçu', 'en_stock', 'en_expédition', 'livré', 'retour'])->default('reçu');
            $table->date('date_reception');
            $table->date('date_expedition')->nullable();
            $table->boolean('fragile')->default(false);
            $table->foreignUuid('client_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignUuid('transporteur_id')->nullable()->constrained('transporteurs')->nullOnDelete();
            $table->foreignId('emplacement_id')->nullable()->constrained('emplacements')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colis');
    }
};
