<?php

namespace App\Http\Livewire;

use App\Models\McWarehouse as ModelsMcWarehouse;
use App\Models\McWarehousQuantity;
use App\Models\Medicine;
use App\Models\RmWarehouse;
use Livewire\Component;

class McWarehouse extends Component
{

    public $products;

    protected $listeners = ['add' => 'addProd','delete' => 'deleteProd'];


    public function mount()
    {
        $medicines = Medicine::orderBy('id','ASC')->get();
        $warehouses = ModelsMcWarehouse::orderBy('id','ASC')->get();

        foreach ($medicines as $key => $value) {
            foreach ($warehouses as $ware) {

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
        
        $this->products = RmWarehouse::with('medicine')->orderBy('id')->get();

        // dd($this->products[0]->medicine->name);
    }

    public function addProd($id)
    {
        $product = RmWarehouse::where('product_id',$id)->first();
        $product->quantity = $product->quantity + 1;
        $product->save();
        $this->dispatchBrowserEvent('refresh-page'); 

    }

    public function deleteProd($id)
    {
        $product = RmWarehouse::where('product_id',$id)->first();
        if($product->quantity > 0)
        {
            $product->quantity = $product->quantity - 1;
            $product->save();
        }
        $this->dispatchBrowserEvent('refresh-page'); 
        
    }

    public function render()
    {
        return view('livewire.mc-warehouse');
    }
}
