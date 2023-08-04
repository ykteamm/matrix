<div>
    <div class="content container-fluid main-wrapper">
        <div class="row gold-box">
           @include('admin.components.logo')
           <div class="card flex-fill">
              <div style="border-bottom-radius:30px !important;margin-left:auto">
                 <div class="justify-content-between align-items-center p-2" >
                      <div class="btn-group">
                       <div class="row">
                          <div class="col-md-12" align="center">
                                   Viloyat
                          </div>
                          <div class="col-md-12">
                             <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{$active_region}}
                            </button>
                             <div class="dropdown-menu" style="left:150px !important">
                             <a href="#" wire:click="$emit('change_Region','all')"  class="dropdown-item"> Hammasi </a>
                                @foreach($regions as $region)
                                <a href="#" wire:click="$emit('change_Region',{{$region->id}})"  class="dropdown-item"> {{$region->name}} </a>
                                @endforeach
                             </div>
                          </div>
                       </div>
                      </div>
                      {{-- <div class="btn-group">
                           <div class="row">
                             <div class="col-md-12" align="center">
                                      Sana
                             </div>
                             <div class="col-md-12">
                                <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button2" name="a_today"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Bugun </button>
                                <div class="dropdown-menu timeclass">
                                <a href="#" onclick="timeElchi('a_all')" class="dropdown-item" id="a_all">Hammasi </a>
     
                                   <a href="#" onclick="timeElchi('a_today')" class="dropdown-item" id="a_today"> Bugun </a>
                                   <a href="#" onclick="timeElchi('a_week')" class="dropdown-item" id="a_week">Hafta </a>
                                   <a href="#" onclick="timeElchi('a_month')" class="dropdown-item" id="a_month">Oy  </a>
                                   <a href="#" onclick="timeElchi('a_year')" class="dropdown-item" id="a_year">Yil </a>
                             <input type="text" name="datetimes" class="form-control"/>
     
                                </div>
                             </div>
                          </div>
                      </div> --}}
                      {{-- <div class="btn-group">
                          <div class="row">
                              <div class="col-md-12" align="center">
                                      Mahsulot
                              </div>
                              <div class="col-md-12">
                              <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button3" title="all" name="all" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Hammasi</button>
                              <div class="dropdown-menu" style="overflow-y:scroll; height:400px;">
     
                              <a href="#" onclick="medicine('Hammasi','all')" class="dropdown-item"> Hammasi </a>
                                  @foreach($category as $cat)
                                  <a href="#" style="color:red;font-size:20px" onclick="medicineCat(`{{$cat->name}}`,`{{$cat->id}}`,'all')" class="dropdown-item"><b> {{$cat->name}} </b></a>
     
                                  @foreach($medicine as $med)
                                      @if($cat->id == $med->category_id)
                                          <a href="#" style="margin-left:5%;" onclick="medicine(`{{$med->name}}`,`{{$med->id}}`,'all')" class="dropdown-item"> {{$med->name}} </a>
                                      @endif
                                  @endforeach
                                  @endforeach
                              </div>
                              </div>
                          </div>
                      </div> --}}
                      {{-- <div class="btn-group">
                          <div class="row">
                             <div class="col-md-12" align="center">
                                      Elchi
                             </div>
                             <div class="col-md-12">
                                <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button4" name="all" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Hammasi</button>
                                <div class="dropdown-menu" style="overflow-y:scroll; height:400px;">
                                   <a href="#" onclick="users('Hammasi','all')" class="dropdown-item" id="addregionall"> Hammasi </a>
                                   
                                </div>
                             </div>
                          </div>
                      </div> --}}
                      {{-- <div class="btn-group" style="margin-right:30px !important;margin-top:20px;">
                          <div class="row">
                             <div class="col-md-12" align="center">
     
                             </div>
                             <div class="col-md-12">
                                <button type="button" class="btn btn-block btn-outline-primary" onclick="refresh()"> Tozalash</button>
     
                             </div>
                          </div>
                      </div> --}}
                 </div>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Viloyat</th>
                            <th>Otgruzka</th>
                            <th>Eski yopilgan pul</th>
                            <th>Yangi yopilgan pul</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($regions as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td>{{$otgruzka[$item->id]}}</td>
                                <td>{{$last_close_money[$item->id]}}</td>
                                <td>{{$new_close_money[$item->id]}}</td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
           </div>
        </div>
    </div>
</div>
