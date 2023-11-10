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
        Schema::create('users', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('first_name', 51);
            $table->string('last_name', 51)->nullable();
            $table->string('email', 51)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 251);
            $table->boolean('is_active')->comment('0:Blocked,1:Active');
            $table->boolean('is_first_login')->comment('0:No,1:Yes');
            $table->char('code', 6)->nullable();
            $table->enum('type', ['admin', 'user'])->default('user');
            $table->char('created_by', 36)->nullable(); // Create By Wich User
            $table->char('updated_by', 36)->nullable(); // Update By Wich User
            $table->char('deleted_by', 36)->nullable(); // Delete By Wich User
            $table->boolean('is_deleted', 36)->default(0)->comment('0:False, 1:True)');
            $table->timestamps(); // Adds created_at and updated_at columns
            $table->softDeletes(); // Adds deleted_at Datatype Timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
