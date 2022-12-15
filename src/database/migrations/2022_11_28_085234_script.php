<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Scripts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('broadcast_year')->nullable();
            $table->string('genre')->nullable();
            $table->string('company')->nullable();
            $table->string('writer')->nullable();
            $table->string('original')->nullable();
            $table->string('award')->nullable();
            $table->text('outline')->nullable();
            $table->text('image')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('Scripts');
    }
};
