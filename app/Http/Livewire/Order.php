<?php

namespace App\Http\Livewire;

use App\Models\Medicine;
use App\Models\Shablon;
use Livewire\Component;
use Mockery\Undefined;

class Order extends Component
{
    public $products;
    public $prod;

    public $skida;
    public $summa = 0;
    public $skidka_summa;

    public $prod_array = [];
    public $prod_count = [];
    public $order_product = [];

    protected $listeners = ['delete_prod' => 'deleteProd'];
    

    public function mount()
    {
        $this->products = Medicine::all();
    }

    public function deleteProd($key,$id)
    {
        if (($k = array_search($id, $this->prod_array)) !== false) {
            unset($this->prod_array[$k]);
        }
        unset($this->order_product[$key]);

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
    }

    public function render()
    {
        
       
        return view('livewire.order');
    }
}
