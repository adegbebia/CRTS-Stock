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
        Schema::create('mouvement_articles', function (Blueprint $table) {
            $table->id('mouvementArt_id');
            $table->integer('article_id');
            $table->date('date');
            $table->string('origine')->nullable(); 
            $table->integer('quantite_commandee')->nullable();
            $table->integer('quantite_entree')->nullable();
            $table->integer('quantite_sortie')->nullable();
            // $table->integer('stock_debut_mois');
            $table->integer('avarie')->nullable();
            $table->integer('nombre_rupture_stock')->nullable(); 
            $table->integer('stock_jour');
            $table->text('observation')->nullable(); 
            $table->foreign('article_id')->references('article_id')->on('articles')->onDelete('cascade');
            $table->timestamps();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mouvement_articles');
    }
};
