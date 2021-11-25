<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportedPlayerCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reported_player_comments', function (Blueprint $table) {
            $db = DB::connection('mongodb')->getDatabaseName();
            $table->id();
            $table->string('comment_id');
            $table->string('policy_id');
            $table->string('user_id');
            $table->string('user_notes');
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
        Schema::dropIfExists('reported_player_comments');
    }
}
