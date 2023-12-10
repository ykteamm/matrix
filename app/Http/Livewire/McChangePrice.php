<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Medicine;
use App\Models\McOrderDetail;
use App\Models\McOrder;

class McChangePrice extends Component
{
    public $medicine;
    public $med_id;
    public $orders = [];

    public function mount()
    {
        $this->medicine = Medicine::orderBy('name','ASC')->get();
    }

    public function change()
    {
        $ids = McOrderDetail::where('product_id',$this->med_id)->pluck('order_id');
        $id = $this->med_id;
        $this->orders = McOrder::with([
            'order_detail' => function ($q) use($id) {
                $q->where('product_id', $id);
            }, 
            'order_delivery' => function ($u) use($id){
                $u->where('product_id', $id);
            }
            ])->whereIn('id',$ids)->orderBy('id','ASC')->get();
        // dd($this->orders[0]);
    }

    public function findPharmacy($search)
    {
        
        if($search != null)
        {
            $this->pharmacy_or_user = Medicine::with('region')->whereIn('id',$apt)->whereIn('region_id',$region_id)
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

    public function render()
    {
        return view('livewire.mc-change-price');
    }
}
