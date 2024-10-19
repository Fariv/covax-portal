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
        Schema::table('users_vaccine_centers', function (Blueprint $table) {
            $table->string("centers_id")->nullable()->change();
            $table->foreign("users_id")->references("id")->on("users")->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("centers_id")->references("id")->on("vaccine_centers")->onUpdate("cascade")->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_vaccine_centers', function (Blueprint $table) {
            $table->dropForeign(['users_id', "centers_id"]);
        });
    }
};
