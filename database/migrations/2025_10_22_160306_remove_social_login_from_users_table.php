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
            // Drop social login columns
            $table->dropUnique(['google_id']);
            $table->dropUnique(['facebook_id']);
            $table->dropColumn(['google_id', 'facebook_id', 'avatar_url', 'provider']);

            // Make password not nullable again
            $table->string('password')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Restore social login columns
            $table->string('google_id')->nullable()->unique()->after('email');
            $table->string('facebook_id')->nullable()->unique()->after('google_id');
            $table->string('avatar_url')->nullable()->after('facebook_id');
            $table->string('provider')->nullable()->after('avatar_url');

            // Make password nullable again
            $table->string('password')->nullable()->change();
        });
    }
};
