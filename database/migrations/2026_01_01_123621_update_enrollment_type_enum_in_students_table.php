<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE students 
            MODIFY enrollment_type 
            ENUM('trial', 'instant', 'after_trial') 
            NOT NULL DEFAULT 'trial'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE students 
            MODIFY enrollment_type 
            ENUM('trial', 'instant') 
            NOT NULL DEFAULT 'trial'
        ");
    }
};
