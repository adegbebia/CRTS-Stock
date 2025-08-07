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
        Schema::create('alerte_produits', function (Blueprint $table) {
            $table->id('alerteProd_id');
            $table->string('typealerte');
            $table->timestamp('datedeclenchement')->useCurrent();
            $table->integer('produit_id');
            $table->foreign('produit_id')->references('produit_id')->on('produits')->OnDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerte_produits');
    }
};
