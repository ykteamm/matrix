<div class="content mt-1 main-wrapper ">
    <div class="row gold-box">
    @include('admin.components.logo')
    <div class="card flex-fill">
     <div style="border-bottom-radius:30px !important;margin-left:auto">

      <div class="justify-content-between align-items-center p-2" >

        <div class="btn-group mr-5 ml-auto">
          <div class="row">
             <div class="col-md-12" align="center">
                      Viloyat
             </div>
             <div class="col-md-12">
                <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{$this->region_name}} </button>
                <div class="dropdown-menu timeclass">
                    @foreach ($regions as $key => $item)
                        <a type="button" wire:click="region(`{{$item->id}}`,`{{$item->name}}`)" class="dropdown-item">{{$item->name}}</a>
                    @endforeach
                </div>
             </div>
          </div>
        </div>
        <div class="btn-group mr-5 ml-auto">
            <div class="row">
               <div class="col-md-12" align="center">
                        Sana
               </div>
               <div class="col-md-12">
                  <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button2" name="a_all"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{$time_text}} </button>
                  <div class="dropdown-menu timeclass">
                     <a type="button" wire:click="times('today','Bugun')" class="dropdown-item">Bugun</a>
                     <a type="button" wire:click="times('week','Hafta')" class="dropdown-item">Hafta</a>
                     <a type="button" wire:click="times('month','Oy')" class="dropdown-item">Oy</a>
                     <a type="button" wire:click="times('year','Yil')" class="dropdown-item">Yil</a>
                     <a type="button" wire:click="times('all','Hammasi')" class="dropdown-item" id="aftertime">Hammasi</a>
                     {{-- <input type="date" wire:model="begin_date" name="begin_date" class="form-control"/> --}}
                     {{-- <input type="text" wire:model="begin_date" name="datetimes" class="form-control"/> --}}
                  </div>
               </div>
            </div>
        </div>
    </div>
</div>  
     </div>
    </div>
    <div class="card headbot">
        <div class="card-header no-border">
        <h5 class="card-title"> Mahsulotlar reytingi </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-nowrap mb-0">
                    <thead>
                        <tr>
                        <th># </th>
                        <th>Mahsulot </th>
                        <th>Summa </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($medicine as $key => $item)
                        <tr>
                            <td>#{{$key+1}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{number_format($item->allprice,0,'','.')}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
