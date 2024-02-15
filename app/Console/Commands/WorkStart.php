<?php

namespace App\Console\Commands;

use App\Models\ProductSold;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class WorkStart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elchi:workstart';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $users = User::whereDate('date_joined','>','2022-08-01')->get();

        foreach ($users as $key => $value) {
            $pro = ProductSold::where('user_id',$value->id)->first();
            if($pro)
            {
                $sum = 0;
                for ($i=1; $i < 30; $i++) {
                    $d = date('Y-m-d',strtotime('+'.$i.' day',strtotime($pro->created_at)));
                    $sold = ProductSold::where('user_id',$value->id)
                    ->whereDate('created_at','>=',$pro->created_at)
                    ->whereDate('created_at','<=',$d)
                    ->sum(DB::raw('number*price_product'));
                    if($sold >= 1750000)
                    {
                        $update = DB::table('tg_user')->where('id',$value->id)->update([
                            'status' => 1,
                            'work_start' => $d
                        ]);
                        break;
                    }
                }
            }
        }
    }
}
