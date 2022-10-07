<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class everyWeek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Yakshanba kuni savollarni elchiga biriktirish';

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
        // DB::table('tg_user')->first();
        echo "My first schedule";
    }
}
