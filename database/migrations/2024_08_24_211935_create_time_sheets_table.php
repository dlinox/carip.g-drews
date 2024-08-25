<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /*
        TYPES
        Dias trabajados           T
        Dias no trabajados        N 			
        faltas injustificadas	  I 		
        Permisos			      P 
        Mantenimiento		      M     	
        Casos de emergencia		  E     	
    */

    public function up(): void
    {
        Schema::create('time_sheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained();
            $table->foreignId('vehicle_id')->constrained();

            $table->unsignedBigInteger('operator_id')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->date('register_at');
            $table->enum('type', ['T', 'N', 'I', 'P', 'M', 'E'])->nullable();

            $table->foreign('operator_id')->references('id')->on('operators');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_sheets');
    }
};
