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
        Schema::create('link_analytics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('short_url_id');
            $table->unsignedInteger('count')->default(1);
            $table->string('type');
            $table->timestamps();

            $table->foreign('short_url_id')
                ->references('id')
                ->on('short_urls')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('link_analytics');
    }
};
