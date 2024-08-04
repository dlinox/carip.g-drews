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
        Schema::create('operators', function (Blueprint $table) {
            $table->id();
            $table->char('document_type', 3)->default('001');
            $table->string('document_number');
            $table->string('name');
            $table->string('paternal_surname')->nullable();
            $table->string('maternal_surname')->nullable();
            $table->date('birthdate')->nullable();
            $table->char('birth_place', 6)->nullable();
            $table->char('residence_place', 6)->nullable();
            $table->string('phone');
            $table->string('email');
            $table->enum('gender', ['M', 'F', 'O'])->default('O');
            $table->char('license_number', 10)->nullable();
            $table->string('license_category', 10)->nullable();
            //fecha de vencimiento de la licencia
            $table->date('license_expiration_date')->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operators');
    }
};
