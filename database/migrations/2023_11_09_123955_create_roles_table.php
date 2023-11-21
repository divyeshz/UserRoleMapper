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
        Schema::create('roles', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('name', 51);
            $table->string('description', 151);
            $table->boolean('is_active')->default(1)->comment('0:Blocked,1:Active');
            $table->char('created_by', 36)->nullable(); // Create By Wich User
            $table->char('updated_by', 36)->nullable(); // Update By Wich User
            $table->char('deleted_by', 36)->nullable(); // Delete By Wich User
            $table->boolean('is_deleted')->default(0)->comment('0:False, 1:True)');
            $table->timestamps(); // Adds created_at and updated_at columns
            $table->softDeletes(); // Adds deleted_at Datatype Timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
