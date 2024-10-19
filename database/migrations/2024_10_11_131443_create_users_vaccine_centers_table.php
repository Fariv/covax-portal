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
        Schema::create('users_vaccine_centers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("users_id");
            $table->unsignedBigInteger("centers_id");
            $table->dateTime("schedule_vaccination_date")->nullable();
            $table->string("status")->default("Not scheduled");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_vaccine_centers');
    }
};
