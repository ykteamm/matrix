<?php

namespace App\Http\Livewire;

use App\Models\CrystalUser as ModelsCrystalUser;
use App\Models\User;
use Livewire\Component;

class CrystalUser extends Component
{
    public $ids;
    public $crystal = [];
    public $detail = [];
    public $user;

    protected $listeners = ['delete' => 'deleteCrystal'];

    public function mount()
    {

        $this->ids = ModelsCrystalUser::distinct('user_id')->pluck('user_id');

        foreach ($this->ids as $key => $value) {

            $this->crystal[$value] = ModelsCrystalUser::where('user_id',$value)->sum('crystal');
            $this->detail[$value] = ModelsCrystalUser::where('user_id',$value)->get();

        }

        $this->user = User::whereIn('id',$this->ids)->get();


    }

    public function deleteCrystal($id)
    {
        ModelsCrystalUser::find($id)->delete();

        return redirect()->to('/crystal-add');
    }

    public function render()
    {
        return view('livewire.crystal-user');
    }
}
