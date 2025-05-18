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
        Schema::create('game_groups', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Explicitly set storage engine (optional)
            $table->id(); // Auto-incrementing primary key (unsigned bigint)
            $table->string('color'); // Group color (e.g., 'green', 'red')
            $table->timestamp('generated_at')->nullable(); // Made nullable
            $table->timestamps(); // Adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_groups'); // Proper cleanup
    }
};
