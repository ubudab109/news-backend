<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')->constrained('sources')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('external_id')->index()->nullable();
            $table->string('author')->index()->nullable();
            $table->string('category')->index()->nullable();
            $table->text('title')->index();
            $table->longText('content');
            $table->longText('thumbnail')->nullable();
            $table->dateTime('published_date')->nullable();
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
        Schema::dropIfExists('news');
    }
}
