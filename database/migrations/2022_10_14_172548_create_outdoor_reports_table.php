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
        Schema::create('outdoor_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outdoor_location_id');
            $table->date('report_date');
            $table->string('frame_status',255);
            $table->string('paint_status',255);
            $table->string('print_status',255);
            $table->string('light_status',255);
            $table->string('note',255)->nullable();
            $table->string('morning_image',2083);
            $table->string('night_image',2083);
            $table->string('report_file',2083)->nullable();
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
        Schema::dropIfExists('outdoor_reports');
    }
};
