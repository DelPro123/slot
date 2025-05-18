<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::create('game_group_game', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->unsignedBigInteger('game_group_id');
            $table->unsignedBigInteger('game_id');
            $table->timestamps();

            $table->primary(['game_group_id', 'game_id']); // Composite primary key

            // Add indexes first
            $table->index('game_group_id');
            $table->index('game_id');
        });

        // Add foreign keys in separate statements
        DB::statement('
            ALTER TABLE game_group_game
            ADD CONSTRAINT fk_game_group_game_group
            FOREIGN KEY (game_group_id)
            REFERENCES game_groups(id)
            ON DELETE CASCADE
        ');

        DB::statement('
            ALTER TABLE game_group_game
            ADD CONSTRAINT fk_game_group_game
            FOREIGN KEY (game_id)
            REFERENCES games(id)
            ON DELETE CASCADE
        ');

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('game_group_game');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
