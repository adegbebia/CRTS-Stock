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
        Schema::create('alerte_articles', function (Blueprint $table) {
            $table->id('alerteArt_id');
            $table->integer('article_id');
            $table->string('typealerte');
            $table->timestamp('datedeclenchement')->useCurrent();
            $table->foreign('article_id')->references('article_id')->on('articles')->OnDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerte_articles');
    }
};
