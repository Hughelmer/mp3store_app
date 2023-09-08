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
        Schema::create('songs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('audio_file', 255)->nullable();
            $table->double('duration', 8, 2)->nullable(); // Allow for NULL duration initially
            $table->unsignedBigInteger('artist_id');
            $table->unsignedBigInteger('album_id')->nullable();

            // Define foreign key constraint
            $table->foreign('artist_id')->references('id')->on('artists')->onDelete('cascade');
            $table->foreign('album_id')->references('id')->on('albums')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * 
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
