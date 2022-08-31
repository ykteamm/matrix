@extends('layouts.app')

    @section('content')
    <div class="content container-fluid">
               <div class="row">
                  <div class="col-12 col-md-6 col-lg-2 d-flex flex-wrap">
                     <div class="card detail-box1 details-box">
                        <div class="card-body">
                           <div class="dash-contetnt">
                              <div class="mb-3">
                                 <img src="assets/img/icons/people.png" alt="" width="26" />
                              </div>
                              <h4 class="text-white">{{__('app.all_p')}}</h4>
                              @isset($all_patient)
                              <h2 class="text-white"> {{ $all_patient }} </h2>
                              @endisset
                              {{-- <div class="growth-indicator">
                                 <span class="text-white"><i class="fas fa-angle-double-up mr-1"></i> (14.25%) </span>
                              </div> --}}
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-md-6 col-lg-2 d-flex flex-wrap">
                     <div class="card detail-box2 details-box">
                        <div class="card-body">
                           <div class="dash-contetnt">
                              <div class="mb-3">
                                 <img src="assets/img/icons/hospital-bed.svg" alt="" width="26" />
                              </div>
                              <h4 class="text-white">{{__('app.all_chkb')}} </h4>
                              @isset($all_chkb)
                              <h2 class="text-white"> {{ $all_chkb }} </h2>
                              @endisset
                              {{-- <div class="growth-indicator">
                                 <span class="text-white"><i class="fas fa-angle-double-down mr-1"></i> (4.78%) </span>
                              </div> --}}
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-md-6 col-lg-2 d-flex flex-wrap">
                     <div class="card detail-box3 details-box">
                        <div class="card-body">
                           <div class="dash-contetnt">
                              <div class="mb-3">
                                 <img src="assets/img/icons/happiness.png" alt="" width="26" />
                              </div>
                              <h4 class="text-white">{{__('app.all_no_dead_chkb_t')}} </h4>
                              @isset($all_true)
                              <h2 class="text-white"> {{ $all_true }} </h2>
                              @endisset
                              {{-- <div class="growth-indicator">
                                 <span class="text-white"><i class="fas fa-angle-double-up mr-1"></i> (18.32%) </span>
                              </div> --}}
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-md-6 col-lg-2 d-flex flex-wrap">
                     <div class="card detail-box4 details-box">
                        <div class="card-body">
                           <div class="dash-contetnt">
                              <div class="mb-3">
                                 <img src="assets/img/icons/happiness.png" alt="" width="26" />
                              </div>
                              <h4 class="text-white">{{__('app.all_no_chkb')}} </h4>
                              @isset($chkb_true)
                              <h2 class="text-white"> {{ $chkb_false }} </h2>
                              @endisset
                              {{-- <div class="growth-indicator">
                                 <span class="text-white"><i class="fas fa-angle-double-down mr-1"></i> (25.14%) </span>
                              </div> --}}
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-md-6 col-lg-2 d-flex flex-wrap">
                     <div class="card detail-box5 details-box">
                        <div class="card-body">
                           <div class="dash-contetnt">
                              <div class="mb-3">
                                 <img src="assets/img/icons/operating.svg" alt="" width="26" />
                              </div>
                              <h4 class="text-white">{{__('app.all_dead_chkb_l_t')}}</h4>
                              @isset($all_false)
                              <h2 class="text-white"> {{ $all_false }} </h2>
                              @endisset
                              {{-- <div class="growth-indicator">
                                 <span class="text-white"><i class="fas fa-angle-double-down mr-1"></i> (25.14%) </span>
                              </div> --}}
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-md-6 col-lg-2 d-flex flex-wrap">
                     <div class="card detail-box6 details-box">
                        <div class="card-body">
                           <div class="dash-contetnt">
                              <div class="mb-3">
                                 <img src="assets/img/icons/operating.svg" alt="" width="26" />
                              </div>
                              <h4 class="text-white">{{__('app.all_dead_chkb')}} </h4>
                              @isset($chkb_false)
                              <h2 class="text-white"> {{ $chkb_false }} </h2>
                              @endisset
                              {{-- <div class="growth-indicator">
                                 <span class="text-white"><i class="fas fa-angle-double-down mr-1"></i> (25.14%) </span>
                              </div> --}}
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row calender-col">
                  <div class="col-xl-4">
                     <div class="card">
                        <div class="card-header">
                           <h4 class="card-title">Гендерная статистика</h4>
                        </div>
                        <div class="card-body">
                           <div id="chart_pie"></div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-8 d-flex">
                     <div class="card flex-fill">
                        <div class="card-header">
                           <div class="d-flex justify-content-between align-items-center">
                              <h5 class="card-title">Статистика возраста </h5>
                              <div class="dropdown" data-toggle="dropdown">
                                 {{-- <a href="javascript:void(0);" class="btn btn-white btn-sm dropdown-toggle" role="button" data-toggle="dropdown">
                                 This Week
                                 </a> --}}
                                 <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button" role="button" data-toggle="dropdown"> Все </button>
                                 <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#" onclick="ageChart('a_today')" class="dropdown-item" id="a_today"> Сегодня </a>
                                    <a href="#" onclick="ageChart('a_week')" class="dropdown-item" id="a_week">Неделя </a>
                                    <a href="#" onclick="ageChart('a_month')" class="dropdown-item" id="a_month">Месяц  </a>
                                    <a href="#" onclick="ageChart('a_year')" class="dropdown-item" id="a_year">Год </a>
                                    <a href="#" onclick="ageChart('a_all')" class="dropdown-item" id="a_all">Все </a>
                                 </div>
                                 {{-- <div class="form-group">
                                    <select class="form-control">
                                        <option>Default select1</option>
                                        <option>Default select2</option>
                                        <option>Default select3</option>
                                    </select>
                                </div> --}}
                              </div>
                           </div>
                        </div>
                        <div class="card-body">
                           {{-- <div class="d-flex align-items-center justify-content-between flex-wrap flex-md-nowrap">
                              <div class="w-100 d-md-flex align-items-center mb-3 chart-count">
                                 <div class="mr-3 text-center">
                                    <span>Total Appointments </span>
                                    <p class="h4 text-primary">584 </p>
                                 </div>
                                 <div class="mr-3 text-center">
                                    <span>Old Patients </span>
                                    <p class="h4 text-success">320 </p>
                                 </div>
                                 <div class="mr-3 text-center">
                                    <span>New Patients </span>
                                    <p class="h4 text-warning">264 </p>
                                 </div>
                              </div>
                           </div> --}}
                           <div id="disp_none" style="display: none"></div>
                           <div id="chart_age_2"></div>
                           <div id="chart_age"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row calender-col">
                  <div class="col-xl-12 d-flex">
                     <div class="card flex-fill">
                        <div class="card-header">
                           <div class="d-flex justify-content-between align-items-center">
                              <h5 class="card-title"> Статистика исход </h5>
                           </div>
                        </div>
                        <div class="card-body">
                           {{-- <div class="d-flex align-items-center justify-content-between flex-wrap flex-md-nowrap"> --}}
                              {{-- <div class="w-100 d-md-flex align-items-center mb-3 chart-count"> --}}
                                 <div class="row">
                                    <div class="col-xl-4">
                                        <div class="nav flex-column nav-pills text-center" style="margin-top:20%;font-size:19px;" role="tablist" aria-orientation="vertical">
                                          {{-- <a class="nav-link cool-link active" id="v-pills-all-tab" data-toggle="pill" href="#v-pills-all" role="tab" aria-controls="v-pills-all" aria-selected="true"> Все </a> --}}
                                            <a class="nav-link cool-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"> {{__('app.all_p')}} </a>
                                            <a class="nav-link cool-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false"> {{__('app.all_dead')}} </a>
                                            <a class="nav-link cool-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false"> {{__('app.all_no_dead')}} </a>
                                        </div>
                                    </div>
                                    <div class="col-xl-8">
                                        <div class="tab-content">
                                           {{-- <div class="tab-pane fade show active" id="v-pills-all" role="tabpanel" aria-labelledby="v-pills-all-tab">
                                             <div id="all_3"></div>
                                            </div> --}}
                                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                             <div id="all_chart"></div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                             <div id="all_dead"></div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                             <div id="all_no_dead"></div>
                                            </div>
                                        </div>
                                    </div>
                                {{-- </div> --}}
                              </div>
                           {{-- </div> --}}
                        </div>
                     </div>
                  </div>
               </div>
               {{-- <form class="needs-validation" novalidate="">
                  <div class="form-row">
                      <div class="col-md-4 mb-3">
                          <label for="validationCustom01">First name </label>
                          <input type="text" class="form-control" id="validationCustom01" placeholder="First name" value="Mark" required="">
                          <div class="valid-feedback">
                             Looks good!
                          </div>
                      </div>
                      <div class="col-md-4 mb-3">
                          <label for="validationCustom02">Last name </label>
                          <input type="text" class="form-control" id="validationCustom02" placeholder="Last name" value="Otto" required="">
                          <div class="valid-feedback">
                             Looks good!
                          </div>
                      </div>
                      <div class="col-md-4 mb-3">
                          <label for="validationCustomUsername">Username </label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text" id="inputGroupPrepend">@ </span>
                              </div>
                              <input type="text" class="form-control" id="validationCustomUsername" placeholder="Username" aria-describedby="inputGroupPrepend" required="">
                              <div class="invalid-feedback">
                                 ______ choose a username.
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="form-row">
                      <div class="col-md-6 mb-3">
                          <label for="validationCustom03">City </label>
                          <input type="text" class="form-control" id="validationCustom03" placeholder="City" required="">
                          <div class="invalid-feedback">
                             Please provide a valid ____.
                          </div>
                      </div>
                      <div class="col-md-3 mb-3">
                          <label for="validationCustom04">State </label>
                          <input type="text" class="form-control" id="validationCustom04" placeholder="State" required="">
                          <div class="invalid-feedback">
                             Please provide a valid _____.
                          </div>
                      </div>
                      <div class="col-md-3 mb-3">
                          <label for="validationCustom05">Zip </label>
                          <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" required="">
                          <div class="invalid-feedback">
                             Please provide a valid ___.
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required="">
                          <label class="form-check-label" for="invalidCheck">
                             Agree to terms and __________
                          </label>
                          <div class="invalid-feedback">
                             You must agree before __________.
                          </div>
                      </div>
                  </div>
                  <button class="btn btn-primary" type="submit">Submit form </button>
              </form> --}}
            </div>
            
@endsection