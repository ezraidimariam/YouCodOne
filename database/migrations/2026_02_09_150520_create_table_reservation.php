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
        
    Schema::create('reservation', function (Blueprint $table) {
        $table->id();
         $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
        $table->date('date_reservation');
        $table->time('heure_reservation');
        $table->integer('nombre_personne');
        $table->string('status')->default('en_attente');
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservation', function (Blueprint $table) {
            //
        });
    }
};
