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
        Schema::create('modules', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('code', 7);
            $table->string('name', 64);
            $table->boolean('is_active')->default(1)->comment('0:Blocked,1:Active');
            $table->boolean('is_in_menu')->default(1)->comment('0:False,1:True');
            $table->integer('display_order')->nullable();
            $table->char('parent_id', 36)->nullable();
            $table->char('created_by', 36)->nullable(); // Create By Wich User
            $table->char('updated_by', 36)->nullable(); // Update By Wich User
            $table->char('deleted_by', 36)->nullable(); // Delete By Wich User
            $table->boolean('is_deleted', 36)->default(0)->comment('0:False, 1:True)');
            $table->timestamps(); // Adds created_at and updated_at columns
            $table->softDeletes(); // Adds deleted_at Datatype Timestamps
        });

        Schema::table('modules', function (Blueprint $table) {
            $table->index('id'); // Add an index to the 'id' column
            $table->foreign('parent_id')->references('id')->on('modules')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
