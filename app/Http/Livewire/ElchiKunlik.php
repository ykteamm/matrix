<?php

namespace App\Http\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ElchiKunlik extends Component
{
    public $user;
    public $resime = 1;
    public $savdo4 = [];
    public $oy4 = [];
    public $savdo6 = [];
    public $oy6 = [];
    public $kavrtal4 = 4;
    public $kavrtal6 = 6;
    public $ids;

    protected $listeners = ['for_kunlikmodal' => 'modal','change_resime' => 'change'];

    public function modal($id)
    {
        $this->resime = 2;
        $this->ids = $id;
        $this->user = User::find($id);
        
        foreach ($this->getMonth($this->kavrtal4) as $key => $value) {
            $savdo = DB::table('tg_productssold as p')
                        ->selectRaw('COALESCE(SUM(p.number * p.price_product),0) as prodaja')
                        ->where('p.user_id', $id)
                        ->whereDate('p.created_at','>=', $key)
                        ->whereDate('p.created_at','<=', $value)
                        ->value('prodaja');
            $this->savdo4[] = $savdo;
            $this->oy4[] = date('F',strtotime($key)).'-'.$this->numberFormat($savdo);
        }
        foreach ($this->getMonth($this->kavrtal6) as $key => $value) {
            $savdo = DB::table('tg_productssold as p')
                        ->selectRaw('COALESCE(SUM(p.number * p.price_product),0) as prodaja')
                        ->where('p.user_id', $id)
                        ->whereDate('p.created_at','>=', $key)
                        ->whereDate('p.created_at','<=', $value)
                        ->value('prodaja');
            $this->savdo6[] = $savdo;
            $this->oy6[] = date('F',strtotime($key)).'-'.$this->numberFormat($savdo);
        }
        
        
    }

    

    public function numberFormat($number)
    {
        if ($number < 999999 && $number > 999) {
            $format =  number_format($number / 1000).'K';
        }else if ($number < 999999999 && $number > 999999) {
            $format = number_format($number / 1000000,).'M';
        }else {
            $format = number_format($number, 0, '', '.');
        }
        return $format;
    }

    public function getMonthName()
    {
        return [
            'January' => 'Yanvar',
            'February' => 'Fevral',
            'March' => 'Mart',
            'April' => 'Aprel',
            'May' => 'May',
            'June' => 'Iyun',
            'July' => 'Iyul',
            'August' => 'August',
            'September' => 'Sentabr',
            'October' => 'Oktabr',
            'November' => 'Noyabr',
            'December' => 'Dekabr'
        ];
    }

    public function getMonth($kvartal)
    {
        $array = [];
        for ($i = $kvartal-1; $i >= 0; $i--) {
            $first_date = date('Y-m-01', strtotime("-$i month"));
            $last_date = $this->getLastDate($first_date);
            $array[$first_date] = $last_date;
          }

        return $array;
    }

    public function getLastDate($date)
    {
        $d = Carbon::createFromFormat('Y-m-d', $date)
                        ->lastOfMonth()
                        ->format('Y-m-d');
        return $d;
    }

    public function change()
    {
        $this->resime = 1;
        $this->savdo4 = [];
        $this->oy4 = [];
        $this->savdo6 = [];
        $this->oy6 = [];
    }

    public function render()
    {
        return view('livewire.elchi-kunlik');
    }
}
