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
        Schema::create('consommation_articles', function (Blueprint $table) {
                $table->id('consommationArt_id');
                $table->integer('article_id');
                $table->year('annee'); // année de consommation

                // Colonnes pour chaque mois
                foreach ([
                    'janvier', 'fevrier', 'mars', 'avril', 'mai', 'juin',
                    'juillet', 'aout', 'septembre', 'octobre', 'novembre', 'decembre'
                ] as $mois) {
                    $table->integer("consommation_$mois")->default(0);
                    $table->integer("rupture_$mois")->default(0);
                }

                $table->timestamps();

                $table->foreign('article_id')
                    ->references('article_id')
                    ->on('articles')
                    ->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consommation_articles');
    }
};
