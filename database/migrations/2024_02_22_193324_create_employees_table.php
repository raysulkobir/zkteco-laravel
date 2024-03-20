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
        Schema::create('employees', function (Blueprint $table) {
            $table->Increments('id')->from(111)->unsigned();
            $table->string('name');
            $table->string('position');
            $table->string('email')->nullable()->unique();
            $table->string('pin_code')->nullable();
            $table->integer('emp_id')->nullable();
            $table->text('permissions')->nullable();
            $table->text('schedule_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
