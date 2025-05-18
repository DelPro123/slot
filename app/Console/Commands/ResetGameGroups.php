<?php

namespace App\Console\Commands;

use App\Models\GameGroup;
use Illuminate\Console\Command;
use App\Http\Controllers\GameGroupController;

class ResetGameGroups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-game-groups';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
        {
            GameGroup::whereMonth('generated_at', '<', now('Europe/London')->month)->delete();
            $this->info("Old game groups deleted");
        }

}
