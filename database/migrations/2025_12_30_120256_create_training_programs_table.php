<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_programs', function (Blueprint $table) {
            $table->id(); 

            $table->string('program_code', 50)->unique()->nullable();
            $table->string('program_name', 150);
            $table->text('description')->nullable();
            $table->integer('duration_weeks');

            $table->enum('training_mode', ['Online', 'Offline', 'Hybrid'])
                  ->default('Offline');

            $table->decimal('fees', 10, 2)->default(0.00);

            $table->enum('status', ['Active', 'Inactive'])
                  ->default('Active');

            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_programs');
    }
};
