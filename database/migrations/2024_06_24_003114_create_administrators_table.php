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
        Schema::create('administrators', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60);
            $table->string('paternal_surname', 60)->nullable();
            $table->string('maternal_surname', 60)->nullable();
            $table->char('document_type', 8)->default('DNI');
            $table->char('document_number', 8)->nullable();
            $table->char('phone', 9)->nullable();

            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrators');
    }
};