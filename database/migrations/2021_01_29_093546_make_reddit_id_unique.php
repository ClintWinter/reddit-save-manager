<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeRedditIdUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('saves', function (Blueprint $table) {
            $table->string('reddit_id', 20)->nullable()->change();
            $table->unique(['reddit_id'], 'saves_reddit_id_unique');
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
            $table->string('reddit_id', 20)->nullable(false)->change();
            $table->dropUnique('saves_reddit_id_unique');
        });
    }
}
