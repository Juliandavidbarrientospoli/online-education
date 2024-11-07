<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Ejecuta las migraciones para crear la tabla 'comments'.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->boolean('approved')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones eliminando la tabla 'comments'.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
