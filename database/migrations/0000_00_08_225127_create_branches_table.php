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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->char('geo_code', 6)->default('000000');
            $table->string('country')->default('PER');
            $table->boolean('is_enabled')->default(true);
            //campo para el control que no puede ser eliminado
            $table->boolean('is_protected')->default(false);

            $table->foreign('geo_code')
                ->references('code')
                ->on('locations')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
