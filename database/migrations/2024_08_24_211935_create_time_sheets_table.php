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
        Schema::create('time_sheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained();
            $table->foreignId('vehicle_id')->constrained();
            $table->foreignId('operator_id')->constrained();
            /*
            Dias trabajados           T
            Dias no trabajados        N 			
            faltas injustificadas	  I 		
            Permisos			      P 
            Mantenimiento		      M     	
            Casos de emergencia		  E     	
            */
            $table->enum('type', ['T', 'N', 'I', 'P', 'M', 'E']);
            $table->
            $table->date('date');
            $table->time('start_time');

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
