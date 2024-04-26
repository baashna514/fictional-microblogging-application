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
        Schema::table('favorites', function (Blueprint $table) {
            $table->unsignedBigInteger('favoritable_id');
            $table->string('favoritable_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('favorites', function (Blueprint $table) {
            //
        });
    }
};
