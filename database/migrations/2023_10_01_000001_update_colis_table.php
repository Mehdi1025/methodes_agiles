<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColisTable extends Migration
{
    public function up(): void
    {
        Schema::table('colis', function (Blueprint $table) {
            // Assurez-vous que la colonne description est nullable
            $table->string('description')->nullable()->change();

            // Assurez-vous que la colonne date_reception est de type DATE et non nullable
            $table->date('date_reception')->nullable(false)->change();

            // Assurez-vous que la colonne date_expedition est de type DATE et nullable
            $table->date('date_expedition')->nullable()->change();

            // Assurez-vous que la colonne fragile est de type BOOLEAN
            $table->boolean('fragile')->default(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('colis', function (Blueprint $table) {
            // Revenir à l'état précédent si nécessaire
            $table->string('description')->nullable(false)->change();
            $table->string('date_reception')->change();
            $table->string('date_expedition')->nullable(false)->change();
            $table->boolean('fragile')->default(false)->change();
        });
    }
}
