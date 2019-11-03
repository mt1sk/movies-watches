<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->string('hash', 248)->change();
            $table->dropUnique('movies_hash_unique');
            $table->unique(['hash', 'user_id'], 'movies_hash_user_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropUnique('movies_hash_user_id_unique');
            $table->unique('hash', 'movies_hash_unique');
            $table->string('hash', 250)->change();
        });
    }
}
