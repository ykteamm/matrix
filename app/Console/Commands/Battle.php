<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ElchiBattleSetting;
use Illuminate\Support\Facades\DB;
class Battle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'battle:elchi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elchilarni jangini avtomat qilish';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $db = DB::table('tg_elchi_battle_settings')->first();
        if($db->start_day != 0)
        {
            $db = DB::table('tg_elchi_battle_settings')->update([
                'start_day' => 0,
            ]);
        }else{
            $db = DB::table('tg_elchi_battle_settings')->update([
                'start_day' => 1,
            ]);
        }
        // \Log::info("Cron is working fine!");
    }
}
