<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->integer('uid')->unsigned()->default(0);
            $table->integer('emp_id')->unsigned();
            $table->boolean('state')->default(0);
            $table->time('attendance_time')->default(date("H:i:s"));
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->date('attendance_date')->default(date("Y-m-d"));
            $table->boolean('status')->default(1);
            $table->integer('device_id');
            $table->boolean('type')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
