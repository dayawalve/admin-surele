<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->string('fname');
            $table->string('lname')->nullable();
            $table->string('email')->unique();
            $table->string('phone', 20);

            $table->unsignedBigInteger('college_id');

            $table->boolean('is_active')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->boolean('is_deleted')->default(0)->comment('0 = Not Deleted, 1 = Deleted');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
