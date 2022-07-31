<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDeleteCascades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sources', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
            $table
                ->foreign('author_id')
                ->references('id')
                ->on('users');
        });

        Schema::table('translation_requests', function (Blueprint $table) {
            $table->dropForeign(['source_id']);
            $table
                ->foreign('source_id')
                ->references('id')
                ->on('sources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sources', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
            $table
                ->foreign('author_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });

        Schema::table('translation_requests', function (Blueprint $table) {
            $table->dropForeign(['source_id']);
            $table
                ->foreign('source_id')
                ->references('id')
                ->on('sources')
                ->cascadeOnDelete();
        });
    }
}
