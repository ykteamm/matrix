<?php

namespace App\Http\Livewire;

use App\Models\McDelivery;
use App\Models\McOrder;
use App\Models\McOrderDelivery;
use App\Models\McOrderDetail;
use App\Models\McOrderReturn;
use App\Models\McPayment;
use App\Models\McPaymentHistory;
use App\Models\McReturnHistory;
use App\Models\McWarehouse;
use App\Models\McWarehousQuantity;
use App\Models\Medicine;
use App\Models\RmOrder;
use App\Models\RmOrderProduct;
use App\Models\RmWarehouse;
use App\Models\Shablon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

use function PHPSTORM_META\elementType;

class McShipment extends Component
{
    public $orders;
    public $warehouses;
    public $ware_products;
    public $order_products;
    public $default_orders;
    public $products;
    public $page;
    public $discount;
    public $delivery;
    public $delivery_id;
    public $order_id;
    public $status_array = [];
    public $active_status = 1;
    public $ware_id = 1;
    public $saved = 3;
    public $order_datail_status;
    public $payments;
    public $payment_id;

    public $amount;
    public $return_sum;

    public $restart;

    public $detail_delivery;
    public $detail_delivery_date;

    public $error;

    public $money_view = 1;
    public $return_pro = 1;

    public $payment_history = [];
    public $payment_date;
    public $payment_sum;
    public $order_sum;
    public $medicines;

    public $prod_array = [];
    public $order_product = [];
    public $prod_count = [];
    public $prod_price = [];
    public $summa_array = [];

    public $vozvrat = [];
    public $vozvrat_max = [];
    public $return_history;

    public $skidka = 0;

    protected $listeners = ['shipment' => 'shipmentOrder','order_List' => 'orderList', 'save' => 'saveData','change_Status' => 'changeStatus'
    ,'saveMoney_Coming' => 'saveMoneyComing','delete_Error' => 'deleteError','delete_prod' => 'deleteProd','saveOrder_Detail' => 'saveOrderDetail'
    ,'saveReturn' => 'saveReturnData','saveMoney_Return' => 'saveMoneyReturn',
    ];


    public function mount($order_id)
    {
        $this->status_array[1] = 'Yangi';
        $this->status_array[2] = 'Qarzdor';
        $this->status_array[3] = 'Yakunlangan';

        $this->order_id = $order_id;

        $this->order_products = McOrderDetail::with('medicine')->where('order_id',$order_id)->orderBy('id','ASC')->get();



        $this->default_orders = McOrderDetail::where('order_id',$order_id)->pluck('quantity','product_id')->toArray();
        


        foreach ($this->default_orders as $key => $value) {
            $this->products[$key] = 0;
            // $this->vozvrat[$key] = 0;
            // $this->vozvrat_max[$key] = McOrderDelivery::where('order_id',$order_id)->where('product_id',$key)->sum('quantity');
        }



        $this->orders = McOrder::with('pharmacy','user','employe','delivery','payment')->find($order_id);
        
        

        $this->order_datail_status = $this->orders->order_detail_status;

        if($this->orders->delivery_id)
        {
            $this->delivery_id = $this->orders->delivery_id;
        }

        $this->selectWarehouse($this->ware_id);

        $this->discount = $this->orders->discount;

        $this->warehouses = McWarehouse::all();
        $this->delivery = McDelivery::all();

        if($this->order_datail_status != 1)
        {
            $this->detail_delivery_date = McOrderDelivery::where('order_id',$order_id)->distinct('created_at')->pluck('created_at')->toArray();
                foreach ($this->detail_delivery_date as $key => $value) {
                    // $value = date('Y-m-d H:i',strtotime($value));

                    $d = date('Y-m-d H:i:s',strtotime($value));
                    $h = date('H:i:s',strtotime($value));

                    $delivery_q = McOrderDelivery::where('order_id',$order_id)
                    ->whereDate('created_at',$d)
                    ->whereTime('created_at', '=', $h)
                    ->pluck('quantity','product_id')->toArray();

                    $this->detail_delivery[] = $delivery_q;
                }
            // dd(date('Y-m-d H:i:s',strtotime($this->detail_delivery_date[0])),$this->detail_delivery);
        }


        $this->payments = McPayment::all();

        $this->ware_products = McWarehousQuantity::where('warehouse_id',$this->ware_id)->pluck('quantity','product_id')->toArray();

        $this->payment_date = McPaymentHistory::where('order_id',$order_id)->distinct('created_at')->pluck('created_at')->toArray();

        $this->payment_sum = McPaymentHistory::where('order_id',$order_id)->sum('amount');

        foreach ($this->payment_date as $key => $value) {
            $paymnet_q = McPaymentHistory::where('order_id',$order_id)->where('created_at',$value)->pluck('amount','payment_id')->toArray();
            $this->payment_history[] = $paymnet_q;
        }

        $this->return_history = McReturnHistory::where('order_id',$this->order_id)->orderBy('id','ASC')->get();

        $this->order_sum = McOrderDelivery::where('order_id',$order_id)->sum(DB::raw('quantity * price'));
    }


    public function selectWarehouse($warehouse_id)
    {
        $this->ware_id = $warehouse_id;
        $this->ware_products = McWarehousQuantity::where('warehouse_id',$warehouse_id)->pluck('quantity','product_id')->toArray();
        // foreach ($this->default_orders as $pro_id => $quantity) {
        //     if($quantity > $this->ware_products[$pro_id])
        //     {
        //         $this->saved = 1;
        //     }
        // }

        // if($this->saved != 1)
        // {
        //     $this->saved = 2;
        // }

    }

    public function changeQuantity($quantity,$id)
    {
        if($quantity == "")
        {
            $quantity = 0;
        }

        if(gettype($quantity) == 'string')
        {
            $quantity = intval($quantity);
        }

        $this->products[$id] = $quantity;

    }   

    public function changeReturnQuantity($quantity,$id)
    {
        if($quantity == "")
        {
            $quantity = 0;
        }

        if(gettype($quantity) == 'string')
        {
            $quantity = intval($quantity);
        }

        $this->vozvrat[$id] = $quantity;

    } 

    public function selectDelivery($delivery_id)
    {
        $this->delivery_id = $delivery_id;
    }

    public function changeDiscount($discount)
    {
        if($discount == null || !isset($discount) || $discount == 'Undefined')
        {
            $this->discount = 0;
        }else{
            $this->discount = $discount;
        }
    }

    public function orderList()
    {
        $this->dispatchBrowserEvent('refresh-page'); 
    }

    public function check()
    {
        $this->saved = 3;

        
        foreach ($this->products as $pro_id => $quantity) {
            if($quantity > $this->ware_products[$pro_id])
            {
                $this->saved = 1;
            }
        }

        if(array_sum($this->products) == 0)
        {
            $this->saved = 1;
        }

        if($this->saved != 1)
        {
            $this->saved = 2;
        }

        foreach($this->order_products as $ord)
            {

                if($ord->debt == 0)
                {
                    if($ord->quantity < $this->products[$ord->product_id])
                        {
                            $this->saved = 1;
                        }
                }else{
                    if($ord->debt < $this->products[$ord->product_id])
                        {
                            $this->saved = 1;
                        }
                }

                $sum = McOrderDelivery::where('order_detail_id',$ord->id)->sum('quantity');

                if($sum + $this->products[$ord->product_id] > $ord->quantity)
                {
                    $this->saved = 1;
                }

            }

        
    }


    public function saveReturnData()
    {
        $test = 0;
        foreach($this->vozvrat as $key => $value)
        {
            if($value > $this->vozvrat_max[$key])
            {
                $test += 1;
            }
        }


        if($test > 0)
        {
            $this->error = 1;
        }else{
            $arr_del=[];

            foreach($this->vozvrat as $key => $value)
            {
                
                    $price = McOrderDelivery::where('order_id',$this->order_id)
                    ->where('product_id',$key)
                    ->first();

                    $mm = McOrderReturn::create([
                        'order_id' => $this->order_id,
                        'warehouse_id' => $this->ware_id,
                        'product_id' => $key,
                        'quantity' => $value,
                        'price' => $price->price
                    ]);

                    $arr_del[] = $mm;
                
            }

            foreach ($arr_del as $key => $value) {
                $d = McOrderReturn::find($value->id);
                $d->created_at = $arr_del[0]->created_at;
                $d->save();
            }
        }

    }

    public function saveData()
    {
        if($this->products == null)
        {
            $this->error = 1;
        }else{
            $this->check();
        }

        if($this->saved == 2)
        {
            $arr_del = [];

            foreach($this->order_products as $ord)
            {
                

                if($ord->debt == 0)
                {
                    $sum = McOrderDelivery::where('order_detail_id',$ord->id)->sum('quantity');

                    if($sum + $this->products[$ord->product_id] != $ord->quantity)
                    {
                        if($ord->quantity >= $this->products[$ord->product_id])
                        {
                            $update = McOrderDetail::find($ord->id);
                            $update->debt = $update->debt + $ord->quantity - $this->products[$ord->product_id];
                            $update->save();

                            $update_ware = McWarehousQuantity::where('warehouse_id',$this->ware_id)
                            ->where('product_id',$ord->product_id)->first();
                            $update_ware->quantity = $update_ware->quantity-$this->products[$ord->product_id];
                            $update_ware->save();

                        }
                    }

                    
                }else{
                    if($ord->debt >= $this->products[$ord->product_id])
                        {
                            $update = McOrderDetail::find($ord->id);
                            $update->debt = $update->debt - $this->products[$ord->product_id];
                            $update->save();

                            $update_ware = McWarehousQuantity::where('warehouse_id',$this->ware_id)
                            ->where('product_id',$ord->product_id)->first();
                            $update_ware->quantity = $update_ware->quantity-$this->products[$ord->product_id];
                            $update_ware->save();
                        }
                }


                    $mm = McOrderDelivery::create([
                        'order_id' => $this->order_id,
                        'order_detail_id' => $ord->id,
                        'warehouse_id' => $this->ware_id,
                        'product_id' => $ord->product_id,
                        'quantity' => $this->products[$ord->product_id],
                        'price' => $ord->price
                    ]);

                $arr_del[] = $mm;



            } 

            foreach ($arr_del as $key => $value) {
                $d = McOrderDelivery::find($value->id);
                $d->created_at = $arr_del[0]->created_at;
                $d->save();
            }

            
                $debt_count = McOrderDetail::where('order_id',$this->order_id)->sum('debt');

                if($debt_count == 0)
                {
                    $order_detail_status = 3;
                }else{
                    $order_detail_status = 2;
                }

                McOrder::where('id',$this->order_id)->update([
                    'discount' => $this->discount,
                    'order_detail_status' => $order_detail_status,
                    'delivery_id' => $this->delivery_id,
                ]);

                $this->dispatchBrowserEvent('refresh-page'); 

        }else{
            $this->error = 1;
        }

    }   

    public function moneyView()
    {
        if($this->money_view == 1)
        {
            $this->money_view = 2;
            $this->return_pro = 1;
        }else{
            $this->money_view = 1;
        }
    }

    public function returnProduct()
    {
        if($this->return_pro == 1)
        {
            $this->return_pro = 2;
            $this->money_view = 1;
        }else{
            $this->return_pro = 1;
        }
    }

    public function selectPayment($id)
    {
        $this->payment_id = $id;
    }

    public function addPayAmount($amount)
    {
        $this->amount = $amount;
    }

    public function addReturnSum($amount)
    {
        $this->return_sum = $amount;
    }
    
    public function saveMoneyReturn()
    {

        $ord = McOrder::find($this->order_id);

        $pay = McPaymentHistory::where('order_id',$this->order_id)->sum('amount');

        if(($ord->price-$pay) < $this->return_sum)
        {
            $this->error = 1;
        }else{
            McReturnHistory::create([
                'order_id' => $this->order_id,
                'amount' => $this->return_sum*100/100
            ]);
            $this->dispatchBrowserEvent('refresh-page'); 
        }

        
    }

    public function saveMoneyComing()
    {
        if($this->payment_id && $this->amount)
        {
            $sum_payment = McPaymentHistory::where('order_id',$this->order_id)->sum('amount');
            $order = McOrder::find($this->order_id);
            $order_payment = $order->price - $order->price*$order->discount/100;
            if(($order_payment - $sum_payment) < $this->amount)
            {
                $this->error = 1;

            }else{
                McPaymentHistory::create([
                    'payment_id' => $this->payment_id,
                    'order_id' => $this->order_id,
                    'amount' => $this->amount*100/100
                ]);
                
                $sum_payment_all = McPaymentHistory::where('order_id',$this->order_id)->sum('amount');
                if($sum_payment_all >= $order_payment)
                {
                    $upd = McOrder::find($this->order_id);
                    $upd->payment_status = 2;
                    $upd->save();
                }
                

                $this->dispatchBrowserEvent('refresh-page'); 
            }
            

        }else{
            $this->error = 1;
        }
        
    }  

    public function runError()
    {
        $this->error = 1;
    }

    public function deleteError()
    {
        $this->error = 2;
        $this->dispatchBrowserEvent('refresh-page'); 
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
       
            $this->discount = $this->with_foiz($this->summa_array);
            
            
        }
        

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
        $this->discount = $this->with_foiz($this->summa_array);


    }
    public function deleteProd($key,$id) {
        if (($k = array_search($id, $this->prod_array)) !== false) {
            unset($this->prod_array[$k]);
        }
        unset($this->order_product[$key]);

        $this->summa_array[$id] = 0 * $this->prod_price[$id];

        $this->skidka = $this->with_foiz($this->summa_array);
        $this->discount = $this->with_foiz($this->summa_array);



    }

    public function saveOrderDetail()
    {
        $order = McOrder::find(intval($this->order_id));
        $order->price = array_sum($this->summa_array);
        $order->discount = $this->discount;
        $order->save();
        

        foreach ($this->order_product as $key => $product) {
            McOrderDetail::create([
                'order_id' => $this->order_id,
                'product_id' => $product['id'],
                'quantity' => $this->prod_count[$product['id']],
                'price' => $this->prod_price[$product['id']]
            ]);
        }

        $this->dispatchBrowserEvent('refresh-page'); 

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
    public function render()
    {
        return view('livewire.mc-shipment');
    }
}
