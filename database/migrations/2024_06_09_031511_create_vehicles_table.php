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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            //marca - modelo - placa
            $table->string('name');
            // placa
            $table->string('plate')->unique();
            // marca
            $table->string('brand');
            // modelo
            $table->string('model');
            // color
            $table->string('color');
            // catergoria
            $table->string('category');
            //estado
            $table->string('state');
            //soat
            $table->string('soat');
            //soat fecha de vencimiento
            $table->date('soat_expiration_date');
            // tipo
            $table->string('type');
            //tipo de combustible
            $table->string('fuel_type');
            //capacidad
            $table->string('capacity');
            //kilometraje
            $table->string('mileage');

            $table->boolean('is_enabled')->default(true);
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
