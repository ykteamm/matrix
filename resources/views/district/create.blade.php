@extends('layouts.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="d-flex align-items-center">
                <ul class="breadcrumb ml-2">
                <li class="breadcrumb-item"><a href="/main"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="#">{{ __('app.patient') }} </a></li>
                <li class="breadcrumb-item active">{{ __('app.patient_add') }} </li>
                </ul>
            </div>
        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-md-12">
           <div class="card">
              <div class="card-body">
                 <form action="#">
                    <div class="card-header mb-3">
                        <h5 class="card-title">Pasportniy chast </h5>
                     </div>
                   <div class="row">
                    <div class="form-group col-md-3">
                        <label> PinFL </label>
                        <input type="text" class="form-control form-control-sm" />
                     </div>
                    <div class="form-group col-md-3">
                       <label> ФИО </label>
                       <input type="text" class="form-control form-control-sm" />
                    </div>
                    <div class="form-group col-md-3">
                       <label> Дата рождения </label>
                       <input type="text" id="date" class="form-control form-control-sm" placeholder="дд/мм/гггг"/>
                    </div>
                    <div class="form-group col-md-3" id="patient_age">
                        <label> age </label>
                        <input type="number" class="form-control form-control-sm" id="age" disabled/>
                    </div>
                    <div class="form-group col-md-4">
                        <label> Номер телефона </label>
                        <input type="text" id="phone" class="form-control form-control-sm"/>
                     </div>
                    <div class="form-group col-md-4">
                        <label> Adress </label>
                           <select class="form-control form-control-sm">
                                <option>Toshkent</option>
                                <option>Jizzax</option>
                                <option>Samarqand</option>
                           </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label> viloyat </label>
                           <select class="form-control form-control-sm">
                                <option>Toshkent</option>
                                <option>Jizzax</option>
                                <option>Samarqand</option>
                           </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label> Рост </label>
                           <div class="input-group">
                              
                              <input class="form-control form-control-sm" type="number" id="rost"/>
                              <div class="input-group-prepend">
                                <span class="input-group-text"> метр </span>
                             </div>
                           </div>
                     </div>
                     <div class="form-group col-md-4">
                        <label> Вес </label>
                           <div class="input-group">
                              
                              <input class="form-control form-control-sm" type="number" id="ves"/>
                              <div class="input-group-prepend">
                                <span class="input-group-text"> кг </span>
                             </div>
                           </div>
                     </div>
                    <div class="form-group col-md-4">
                       <label> ИМТ </label>
                       <input type="number" class="form-control form-control-sm" id="imt" disabled/>
                    </div>
                    <div class="form-group text-right col-md-12 m-auto">
                       <button type="submit" class="btn btn-primary">Submit </button>
                    </div>
                   </div>
                 </form>
              </div>
           </div>
        </div>
     </div>
</div>
@endsection