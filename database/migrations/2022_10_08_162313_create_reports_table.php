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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('channel_id');
            $table->date('air_date');
            $table->time('air_time');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('program_id');
            $table->text('grid_item');
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('sponsor_type_id');
            $table->unsignedBigInteger('rerun_id');
            $table->unsignedSmallInteger('duration');
            $table->unsignedBigInteger('program_break_id');
            $table->unsignedBigInteger('sponsor_id');
            $table->text('match')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
};
