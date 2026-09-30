<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('training_program_id');

            $table->decimal('amount', 10, 2); 

            $table->enum('payment_mode', [
                'Cash',
                'UPI',
                'Bank Transfer',
                'Card'
            ]);

            $table->date('payment_date')->default(now());
            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->foreign('student_id')
                  ->references('id')->on('students')
                  ->onDelete('cascade');

            $table->foreign('training_program_id')
                  ->references('id')->on('training_programs')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_payments');
    }
};
