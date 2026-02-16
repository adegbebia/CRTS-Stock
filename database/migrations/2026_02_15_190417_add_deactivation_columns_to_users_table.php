<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // 👈 Ajout nécessaire

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('magasin_affecte');
            $table->timestamp('deactivated_at')->nullable()->after('is_active');
            $table->text('deactivation_reason')->nullable()->after('deactivated_at');
            $table->unsignedBigInteger('deactivated_by')->nullable()->after('deactivation_reason');
            
            $table->softDeletes()->after('deactivated_by');
        });
        
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('CREATE INDEX IF NOT EXISTS users_deactivated_by_index ON users(deactivated_by)');
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->foreign('deactivated_by')
                      ->references('user_id')
                      ->on('users')
                      ->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['deactivated_by']);
            }
            $table->dropColumn([
                'is_active', 
                'deactivated_at', 
                'deactivation_reason', 
                'deactivated_by',
                'deleted_at'
            ]);
        });
    }
};