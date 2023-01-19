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
        Schema::create('event_confirmed_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->time('time_from');
            $table->time('time_to');
            $table->foreignId('day_id')->constrained('days')->onDelete('cascade');
            $table->date('date');
            $table->string('email');
            $table->string('name');
            $table->longText('notes')->nullable();
            $table->longText('meeting_link');
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
        Schema::dropIfExists('event_confirmed_times');
    }
};
