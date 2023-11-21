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
        Schema::create('permission_role', function (Blueprint $table) {
            $table->char('role_id', 36);
            $table->char('permission_id', 36);
            $table->boolean('is_active')->default(1)->comment('0:Blocked,1:Active');
            $table->char('created_by', 36)->nullable(); // Create By Wich User
            $table->char('updated_by', 36)->nullable(); // Update By Wich User
            $table->char('deleted_by', 36)->nullable(); // Delete By Wich User
            $table->boolean('is_deleted')->default(0)->comment('0:False, 1:True)');
            $table->timestamps(); // Adds created_at and updated_at columns
            $table->softDeletes(); // Adds deleted_at Datatype Timestamps


            $table->foreign('role_id')->references('id')->on('roles')->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreign('permission_id')->references('id')->on('permissions')->cascadeOnDelete()->cascadeOnUpdate();

            $table->primary(['role_id', 'permission_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_role');
    }
};
