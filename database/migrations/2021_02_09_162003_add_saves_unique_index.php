<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSavesUniqueIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('saves', function (Blueprint $table) {
            $table->unique(['user_id', 'reddit_id'], 'saves_user_id_reddit_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('saves', function (Blueprint $table) {
            $table->dropUnique('saves_user_id_reddit_id_unique');
        });
    }
}
