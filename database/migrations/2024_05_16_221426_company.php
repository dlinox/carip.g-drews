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

        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->char('ruc', 11)->nullable();
            $table->string('name');
            $table->string('social');
            $table->string('address')->nullable();
            $table->char('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('ubication')->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
