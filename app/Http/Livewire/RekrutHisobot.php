<?php

namespace App\Http\Livewire;

use App\Models\Region;
use App\Models\Rekrut;
use App\Models\RekrutGroup;
use Livewire\Component;

class RekrutHisobot extends Component
{

    public $regions;
    public $gurux;
    public $rekruts;
    public $xolat = [];

    public $region_id;
    public $region_name = 'Barchasi';

    public $xolat_id;
    public $xolat_name = 'Barchasi';
    protected $listeners = [
        'change_Region' => 'changeRegion',
        'change_Xolat' => 'changeXolat',
    ];

    

    public function mount()
    {
        $this->region_id = Region::pluck('id')->toArray();
        $this->xolat_id = [1,2,3,4,5,6,7];

        $this->regions = Region::all();

        $this->gurux = RekrutGroup::all();

        $this->xolat[1] = 'O\'ylab koradi';
        $this->xolat[2] = 'Telefon ko\'tarmadi';
        $this->xolat[3] = 'O\'qishga keladi';
        $this->xolat[4] = 'Ustoz bilan gaplashadi';
        $this->xolat[5] = 'Uyi uzoq';
        $this->xolat[6] = 'O\'qishga kelolmaydi lekin ishlaydi';
        $this->xolat[7] = 'Ishlamaydi';

        $this->rekruts = Rekrut::with('region','group','user')
            ->whereDate('created_at','>','2023-08-25')
            ->orderBy('id','DESC')->get();

    }

    public function changeRegion($id)
    {

        if($id == 'all')
        {
            $this->rekruts = Rekrut::with('region','group','user')
            ->whereDate('created_at','>','2023-08-25')
            ->whereIn('xolat',$this->xolat_id)
            ->orderBy('id','DESC')->get();

            $this->region_name = 'Barchasi';

            $this->region_id = Region::pluck('id')->toArray();

        }else{


            $this->rekruts = Rekrut::with('region','group','user')
            ->where('region_id',$id)
            ->whereIn('xolat',$this->xolat_id)
            ->whereDate('created_at','>','2023-08-25')
            ->orderBy('id','DESC')->get();

            $this->region_name = Region::find($id)->name;

            $this->region_id = [$id];

        }
        
    }

    public function changeXolat($id)
    {

        if($id == 'all')
        {
            $this->rekruts = Rekrut::with('region','group','user')
            ->whereIn('region_id',$this->region_id)
            ->whereDate('created_at','>','2023-08-25')
            ->orderBy('id','DESC')->get();

            $this->xolat_name = 'Barchasi';

            $this->xolat_id = [1,2,3,4,5,6,7];

        }else{
            $this->rekruts = Rekrut::with('region','group','user')
            ->where('xolat',$id)
            ->whereIn('region_id',$this->region_id)
            ->whereDate('created_at','>','2023-08-25')
            ->orderBy('id','DESC')->get();

            $this->xolat_name = $this->xolat[$id];

            $this->xolat_id[] = $id;

        }
        
    }
    public function render()
    {
        return view('livewire.rekrut-hisobot');
    }
}
