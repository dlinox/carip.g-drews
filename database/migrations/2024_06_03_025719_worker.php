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

        Schema::create("workers", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("name");
            $table->string("document");
            $table->string("email");
            $table->string("phone");
            $table->boolean("is_enabled");

            $table->unsignedBigInteger("company_id");
            $table->unsignedBigInteger("area_id");

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');

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
