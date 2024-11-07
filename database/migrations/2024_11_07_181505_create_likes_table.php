<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    /**
     * Ejecuta las migraciones para crear la tabla 'likes'.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Restringir un solo like por usuario por video
            $table->unique(['video_id', 'user_id']);
        });
    }

    /**
     * Revierte las migraciones eliminando la tabla 'likes'.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
