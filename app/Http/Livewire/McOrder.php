<?php

namespace App\Http\Livewire;

use App\Models\McOrder as ModelsMcOrder;
use App\Models\McOrderDetail;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\ProductSold;
use App\Models\Region;
use App\Models\RmOrder;
use App\Models\RmOrderProduct;
use App\Models\Shablon;
use App\Models\User;
use App\Services\McOrderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Mockery\Undefined;

class McOrder extends Component {

    public $code;
    public $outer = 3;
    public $pharmacy_or_user;
    public $pharmacy_pro;
    public $pharmacy_no;
    public $pharmacy_or_user_id;
    public $products;
    public $prod_array = [];
    public $order_product = [];
    public $prod_count = [];
    public $summa_array = [];
    public $prod_price = [];
    public $skidka = 0;
    public $discount;
    public $pharmacy_selected;
    public $medicine_selected;
    public $medicines;

    protected $order_service;

    protected $listeners = ['delete_prod' => 'deleteProd','save' => 'saveOrder','addProd'];
    

    public function mount() {
        $this->code = ModelsMcOrder::orderBy('id','DESC')->first()->id;
    }
    public function selectType($value) {

        $this->order_service = new McOrderService($value);

        $this->outer = $this->order_service->getOuterType();

        $region_id = $this->getSpecialRegionId();

        if($this->outer == 2)
        {
            $this->pharmacy_or_user = User::whereIn('status',[0,1])->get();
        }

        $this->pharmacy_or_user_id = 0;

        $this->order_product = [];

    }

    public function findPharmacy($search)
    {
        $region_id = $this->getSpecialRegionId();

        $pharm_ids = Pharmacy::pluck('id')->toArray();
        $with_sold = ProductSold::distinct('pharm_id')->pluck('pharm_id')->toArray();
        $apt = [];
        $arr = [];
        $pro = [33,36,38,53,61,104,110,111,114,116,117,119,129,130,131,132,134,135,139,145,146,147,148,151,155,159,160,163,164,165,166,167];
        foreach ($pharm_ids as $key => $value) {
            if(!in_array($value,$with_sold) && !in_array($value,$pro))
            {
                $arr[] = $value;
            }
            if(in_array($value,$with_sold))
            {
                $apt[] = $value;
            }
        }

        if($search != null)
        {
            $this->pharmacy_or_user = Pharmacy::with('region')->whereIn('id',$apt)->whereIn('region_id',$region_id)
            ->where('name', 'iLIKE', '%'.$search.'%')
            ->orderBy('region_id','ASC')->get();

            $this->pharmacy_pro = Pharmacy::with('region')->whereIn('id',$pro)->whereIn('region_id',$region_id)
            ->where('name', 'iLIKE', '%'.$search.'%')
            ->orderBy('region_id','ASC')->get();

            $this->pharmacy_no = Pharmacy::with('region')->whereIn('id',$arr)->whereIn('region_id',$region_id)
            ->where('name', 'iLIKE', '%'.$search.'%')
            ->orderBy('region_id','ASC')->get();
        }else{
            $search = '####';
            $this->pharmacy_or_user = Pharmacy::with('region')->whereIn('id',$apt)->whereIn('region_id',$region_id)
            ->where('name', 'LIKE', '%'.$search.'%')
            ->orderBy('region_id','ASC')->get();

            $this->pharmacy_pro = Pharmacy::with('region')->whereIn('id',$pro)->whereIn('region_id',$region_id)
            ->where('name', 'LIKE', '%'.$search.'%')
            ->orderBy('region_id','ASC')->get();

            $this->pharmacy_no = Pharmacy::with('region')->whereIn('id',$arr)->whereIn('region_id',$region_id)
            ->where('name', 'LIKE', '%'.$search.'%')
            ->orderBy('region_id','ASC')->get();
        }
        


    }
    public function findMedicine($search)
    {
        if ($search != null) {
            $this->medicines = Medicine::where('name', 'iLIKE', '%'.$search.'%')->orderBy('id','ASC')->get();
        }else{
            $search = '####';
            $this->medicines = Medicine::where('name', 'iLIKE', '%'.$search.'%')->orderBy('id','ASC')->get();
        }
    }
    public function selectPharmacyOrUser($id) {
 
        $this->pharmacy_or_user_id = $id;

        $this->products = Medicine::all();

        $this->pharmacy_selected = Pharmacy::find($id);

        // $this->findPharmacy('####');

    }

    public function addProd($id) {
        if(!in_array($id,$this->prod_array))
        {
            $this->prod_array[] = $id;

            $pr = Medicine::with(['price' => function($q){
                $shablon_id = Shablon::where('id',5)->first();
                $q->where('shablon_id',$shablon_id->id);
            }])->select('id','name','category_id')->where('id',$id)->first()->toArray();
            
            $this->order_product[] = $pr;

            $this->prod_count[$id] = 1;

            $this->prod_price[$id] = $pr['price'][0]['price'];

            $this->summa_array[$id] = $this->prod_count[$id] * $this->prod_price[$id];

            $this->skidka = $this->with_foiz($this->summa_array);
       
            
        }
        

    }
    public function with_foiz($array)
    {
       $sum = array_sum($array);

       if($sum < 5000000)
       {
        $s = 0;
       }elseif($sum >= 5000000 && $sum < 10000000)
       {
        $s = 5;
       }
       elseif($sum >= 10000000 && $sum < 15000000)
       {
        $s = 10;
       }else{
        $s = 15;
       }
       return $s;
    }
    public function deleteProd($key,$id) {
        if (($k = array_search($id, $this->prod_array)) !== false) {
            unset($this->prod_array[$k]);
        }
        unset($this->order_product[$key]);

        $this->summa_array[$id] = 0 * $this->prod_price[$id];

        $this->skidka = $this->with_foiz($this->summa_array);


    }
    
    public function input($value,$id) {
        if(strlen($value) == 0)
        {
            $v = 1;
        }else{
            $v = $value;
        }
        
        $this->prod_count[$id] = $v;

        $this->summa_array[$id] = $this->prod_count[$id] * $this->prod_price[$id];

        $this->skidka = $this->with_foiz($this->summa_array);


    }

    

    public function saveOrder()
    {
        $order_s = new McOrderService($this->outer);
        $this->discount = $order_s->foiz($this->summa_array);

        if ($this->outer == 1) {
            $this->saveOrderPharmacy();
        } else {
            $this->saveOrderUser();
        }
        
    }

    public function saveOrderPharmacy()
    {
        
        $new_order = ModelsMcOrder::create([

            'pharmacy_id' => $this->pharmacy_or_user_id,
            'employee_id' => Session::get('user')->id,
            'number' => 'P'.($this->code+1),
            'price' => array_sum($this->summa_array),
            'discount' => $this->skidka,
            'order_date' => date('Y-m-d H:i:s'),
            'outer' => $this->outer,

        ]);

            foreach ($this->order_product as $key => $product) {
                McOrderDetail::create([
                    'order_id' => $new_order->id,
                    'product_id' => $product['id'],
                    'quantity' => $this->prod_count[$product['id']],
                    'price' => $this->prod_price[$product['id']]
                ]);
        }

        $this->refreshPage();
    }

    public function saveOrderUser()
    {
        $new_order = ModelsMcOrder::create([

            'user_id' => $this->pharmacy_or_user_id,
            'employee_id' => Session::get('user')->id,
            'number' => 'P'.($this->code+1),
            'price' => array_sum($this->summa_array),
            'discount' => $this->skidka,
            'order_date' => date('Y-m-d H:i:s'),
            'outer' => $this->outer,

        ]);

            foreach ($this->order_product as $key => $product) {
                McOrderDetail::create([
                    'order_id' => $new_order->id,
                    'product_id' => $product['id'],
                    'quantity' => $this->prod_count[$product['id']],
                    'price' => $this->prod_price[$product['id']]
                ]);
        }

        $this->refreshPage();
    }

    public function refreshPage()
    {
        $this->dispatchBrowserEvent('refresh-page'); 
    }
    public function getSpecialRegionId()
    {
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

        return $r_id_array;
    }
    public function render()
    {
        return view('livewire.mc-order');
    }
}
