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
        Schema::create('indicators', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_indicador');
            $table->string('codigo_indicador');
            $table->string('unidad_medida_indicador');
            $table->double('valor_indicador');
            $table->date('fecha_indicador');
            $table->string('tiempo_indicador')->nullable();
            $table->string('origen_indicador');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicators');
    }
};
