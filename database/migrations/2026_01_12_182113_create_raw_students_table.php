<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('raw_students', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('address')->nullable();
            $table->date('dob')->nullable();
            $table->string('education')->nullable();
            $table->string('preferred_technology')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('college')->nullable();

            // ✅ ENUM instead of boolean
            $table->enum('job_assurance', ['yes', 'no'])->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('raw_students');
    }
};
