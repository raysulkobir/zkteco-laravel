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
        Schema::create('finger_devices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->ipAddress('ip');
            $table->integer('tcp_port')->nullable();
            $table->string('serial_number')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finger_devices');
    }
};
