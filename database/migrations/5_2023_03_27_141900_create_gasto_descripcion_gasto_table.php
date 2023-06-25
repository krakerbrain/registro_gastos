<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('descripcion_gasto_gasto', function (Blueprint $table) {
            $table->unsignedBigInteger('gasto_id')->default(0);
            $table->unsignedBigInteger('descripcion_gasto_id');
            $table->foreign('gasto_id')->references('id')->on('gastos')->onDelete('cascade');
            $table->foreign('descripcion_gasto_id')->references('id')->on('descripcion_gastos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gasto_descripcion_gasto');
    }
};
