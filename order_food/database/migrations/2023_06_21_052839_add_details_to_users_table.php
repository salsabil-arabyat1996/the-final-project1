<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.

 * Run the migrations.
 */
public function up(): void
{
    // Using the Schema class to modify the 'users' table
    Schema::table('users', function (Blueprint $table) {
        // Adding a new column named 'role_as' with a tiny integer data type
        $table->tinyInteger('role_as')->default('0')->comment('0=user,1=admin');
    });
}

/**
 * Reverse the migrations.
 */
public function down(): void
{
    // Using the Schema class to modify the 'users' table
    Schema::table('users', function (Blueprint $table) {
        // Dropping (removing) the 'role_as' column from the 'users' table
        $table->dropColumn('role_as');
    });
}

};
