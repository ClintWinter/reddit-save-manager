<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaveTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('save_tag', function (Blueprint $table) {
            $table->primary(['save_id', 'tag_id']);
            $table->unsignedBigInteger('save_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();

            // $table->foreign('save_id')->references('id')->on('saves');
            // $table->foreign('tag_id')->references('id')->on('tags'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('save_tag');
    }
}
