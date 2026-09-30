<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedBigInteger('refer_by_id')
                  ->nullable()
                  ->after('refer_id')
                  ->comment('Student referred by another student');

            // Optional foreign key (recommended)
            $table->foreign('refer_by_id')
                  ->references('id')
                  ->on('students')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['refer_by_id']);
            $table->dropColumn('refer_by_id');
        });
    }
};
