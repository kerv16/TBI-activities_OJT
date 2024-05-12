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
        Schema::table('posts', function (Blueprint $table) {

            $table->unsignedBigInteger('TBI_category');
            $table->foreign('TBI_category')->references('id')->on('categories');
            $table->date('Date_from');
            $table->date('Date_to');
            $table->string('purpose');
            $table->string('conducted_by');
            $table->string('participants');
            $table->string('invitation_email');
            $table->string('reference_slip');
            $table->string('T_O');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            //
        });
    }
};
