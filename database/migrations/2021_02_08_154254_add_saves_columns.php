<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSavesColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('saves', function (Blueprint $table) {
            $table->renameColumn('link', 'reddit_url');
            $table->string('thumbnail_url')->nullable()->after('link');
            $table->string('media_url')->nullable()->after('thumbnail_url');
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
            $table->renameColumn('reddit_url', 'link');
            $table->dropColumn('thumbnail_url');
            $table->dropColumn('media_url');
        });
    }
}
