<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewerTranslationRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviewer_translation_request', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reviewer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('translation_request_id')->constrained('translation_requests')->cascadeOnDelete();
            $table->boolean('approved');
            $table->timestamps();

            // custom index name because the default is too long
            $table->unique(['reviewer_id', 'translation_request_id'], 'review_reviewer_id_translation_request_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviewer_translation_request');
    }
}
