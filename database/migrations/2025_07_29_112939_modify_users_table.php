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
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom baru
            $table->foreignId('role_id')->after('id')->constrained('roles')->default(2); // Default kasir
            $table->string('pin_code', 6)->nullable()->after('password');

            // Ubah kolom name jika diperlukan
            // $table->renameColumn('name', 'full_name');

            // Tambahkan kolom username jika belum ada
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->after('id');
            }

            // Soft deletes
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn(['role_id', 'pin_code']);
            $table->renameColumn('full_name', 'name');
            $table->dropColumn('username');
            $table->dropSoftDeletes();
        });
    }
};
