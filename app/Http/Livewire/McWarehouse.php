<?php

namespace App\Http\Livewire;

use App\Models\McWarehouse as ModelsMcWarehouse;
use App\Models\McWarehousQuantity;
use App\Models\Medicine;
use App\Models\RmWarehouse;
use Livewire\Component;

class McWarehouse extends Component
{

    public $warehouses;
    public $products;
    public $ware_id;
    public $prod_count = [];

    protected $listeners = [
        'select_Warehouse' => 'selectWarehouse',
        'save' => 'saveData'
    ];


    public function mount()
    {
        $medicines = Medicine::orderBy('id','ASC')->get();
        $this->warehouses = ModelsMcWarehouse::orderBy('id','ASC')->get();

        foreach ($medicines as $key => $value) {
            foreach ($this->warehouses as $ware) {

                $med = McWarehousQuantity::where('warehouse_id',$ware->id)
                ->where('product_id',$value->id)->first();
                if(!$med)
                {
                    $new = McWarehousQuantity::create([
                        'warehouse_id' => $ware->id,
                        'product_id' => $value->id
                    ]);
                }
            }
        }
        
    }

    public function selectWarehouse($id)
    {
        $this->products = McWarehousQuantity::where('warehouse_id',$id)->orderBy('id')->get();

            foreach($this->products as $pr)
            {
                $this->prod_count[$pr->product_id] = 0;
            }

        $this->ware_id = $id;
    }

    public function addQuantity($quantity,$id)
    {
        $this->prod_count[$id] = $quantity;
    }

    public function saveData()
    {
        foreach ($this->prod_count as $key => $value) {
            $product = McWarehousQuantity::where('warehouse_id',$this->ware_id)
                ->where('product_id',$key)->first();
            $product->quantity = $product->quantity + $value;
            $product->save();
        }

        $this->dispatchBrowserEvent('refresh-page'); 

    }

    public function render()
    {
        return view('livewire.mc-warehouse');
    }
}
