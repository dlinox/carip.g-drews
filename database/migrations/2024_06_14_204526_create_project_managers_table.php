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
        Schema::create('project_managers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('worker_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('worker_id')->references('id')->on('workers')->onDelete('cascade');
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_managers');
    }
};
