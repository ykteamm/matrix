<?php

namespace App\Http\Livewire;

use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\Region;
use App\Models\RmOrder;
use App\Models\Shablon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Mockery\Undefined;

class Order extends Component
{
    public $products;
    public $pharmacy;
    public $prod;
    public $code;

    public $skidka = 0;
    public $summa = 0;
    public $summa_array = [];
    public $skidka_summa = 0;

    public $prod_array = [];
    public $prod_count = [];
    public $prod_price = [];
    public $order_product = [];

    protected $listeners = ['delete_prod' => 'deleteProd','save' => 'saveOrder'];
    

    public function mount()
    {
        $this->code = RmOrder::count();

        $this->products = Medicine::all();

        if(isset(Session::get('per')['region']) && Session::get('per')['region'] == 'true')
        {
            $r_id_array = DB::table('tg_region')->pluck('id')->toArray();
        }else{
            $r_id_array = [];
            foreach (Session::get('per') as $key => $value) {
                if (is_numeric($key)){
               $r_id_array[] = $key;
                }
            }

        }
        $this->pharmacy = Pharmacy::whereIn('region_id',$r_id_array)->get();
    }

    public function deleteProd($key,$id)
    {
        if (($k = array_search($id, $this->prod_array)) !== false) {
            unset($this->prod_array[$k]);
        }
        unset($this->order_product[$key]);

        $this->summa_array[$id] = 0 * $this->prod_price[$id];

        $this->foiz($this->summa_array);
    }

    public function addProd($id){

        if(!in_array($id,$this->prod_array))
        {
            $this->prod_array[] = $id;

            $pr = Medicine::with(['price' => function($q){
                $shablon_id = Shablon::where('active',false)->first();
                $q->where('shablon_id',$shablon_id->id);
            }])->select('id','name','category_id')->where('id',$id)->first()->toArray();
            
            $this->order_product[] = $pr;

            $this->prod_count[$id] = 1;

            $this->prod_price[$id] = $pr['price'][0]['price'];

            $this->summa_array[$id] = $this->prod_count[$id] * $this->prod_price[$id];
            
            $this->foiz($this->summa_array);



        }
        

    }

    public function input($value,$id){
        if(strlen($value) == 0)
        {
            $v = 1;
        }else{
            $v = $value;
        }
        
        $this->prod_count[$id] = $v;

        $this->summa_array[$id] = $this->prod_count[$id] * $this->prod_price[$id];

        $this->foiz($this->summa_array);
    }

    public function foiz($array)
    {
       $sum = array_sum($array);

       if($sum < 5000000)
       {
            $this->skidka = 0;
       }elseif($sum >= 5000000 && $sum < 10000000)
       {
            $this->skidka = 5;
       }
       elseif($sum >= 10000000 && $sum < 15000000)
       {
            $this->skidka = 10;
       }else{
            $this->skidka = 15;
       }
    }

    public function saveOrder()
    {
        $new_order = RmOrder::create([
            'number' => 'P'.($this->code+1),
            'status' => 1,
            'date' => date('d.m.Y'),
            'discount' => $this->skidka,
            'summa' => array_sum($this->summa_array),
            'discount_summa' => array_sum($this->summa_array)-array_sum($this->summa_array)*$this->skidka/100,
            'pharmcy_id' => $this->pharmacy
        ]);
        dd($new_order);
    }

    public function render()
    {
        
       
        return view('livewire.order');
    }
}
