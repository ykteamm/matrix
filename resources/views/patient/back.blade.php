@extends('layouts.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="d-flex align-items-center">
                    <h5 class="page-title">Dashboard </h5>
                    <ul class="breadcrumb ml-2">
                        <li class="breadcrumb-item"><a href="index.html"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="index.html">Doctor Dashboard </a></li>
                        <li class="breadcrumb-item active">Patients History </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
           <div class="card">
              <div class="card-body">
                 <form action="{{ route('search') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-4"></div>
                       <label class="col-form-label col-md-2">{{ __('app.patient') }} {{__('app.pinfl')}} ({{__('app.pasport')}}) </label>
                       <div class="col-md-6">
                        <div class="input-group">
                           <input class="form-control form-control-sm" type="text" name="pin_pas" required/>
                           <div class="input-group-append">
                              <button class="btn btn-primary btn-sm" type="submit"> Поиск </button>
                           </div>
                        </div>
                     </div>
                    </div>
                 </form>
              </div>
           </div>
        </div>
     </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <ul class="nav nav-tabs nav-tabs-bottom">
                        <li class="nav-item"><a class="nav-link active" href="#solid-tab3" data-toggle="tab">General </a></li>
                        <li class="nav-item"><a class="nav-link" href="#solid-tab4" data-toggle="tab">Family History </a></li>
                        <li class="nav-item"><a class="nav-link" href="#solid-tab5" data-toggle="tab">Relatives </a></li>
                        <li class="nav-item"><a class="nav-link" href="#solid-tab6" data-toggle="tab">Lifestyle </a></li>
                        <li class="nav-item"><a class="nav-link" href="#solid-tab7" data-toggle="tab">Other </a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content pt-0">
                        <div class="tab-pane show active" id="solid-tab3">
                            <div class="tab-data">
                                <div class="tab-left">
                                    <div class="d-flex mb-3">
                                        <div class="medicne d-flex">
                                            <h5>Risk Factors </h5>
                                        </div>
                                        <div class="medicne-time ml-auto">
                                            <h5>Exams/Tests </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="medicne d-flex">
                                            Varicose Veins
                                        </div>
                                        <div class="medicne-time ml-auto">
                                            <p><a href="#">View Report </a></p>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="medicne d-flex">
                                            Hypertension
                                        </div>
                                        <div class="medicne-time ml-auto">
                                            <p><a href="#">View Report </a></p>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="medicne d-flex">
                                            Diabetes
                                        </div>
                                        <div class="medicne-time ml-auto">
                                            <p><a href="#">View Report </a></p>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-0">
                                        <div class="medicne d-flex">
                                            Sickle Cell
                                        </div>
                                        <div class="medicne-time ml-auto">
                                            <p><a href="#">View Report </a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-right">
                                    <div class="d-flex mb-3">
                                        <div class="medicne d-flex">
                                            <h5>Risk Factors </h5>
                                        </div>
                                        <div class="medicne-time ml-auto">
                                            <h5>Exams/Tests </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="medicne d-flex">
                                            Fibroids
                                        </div>
                                        <div class="medicne-time ml-auto">
                                            <p><a href="#">View Report </a></p>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="medicne d-flex">
                                            Severe Migraine
                                        </div>
                                        <div class="medicne-time ml-auto">
                                            <p><a href="#">View Report </a></p>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="medicne d-flex">
                                            Heart Disease
                                        </div>
                                        <div class="medicne-time ml-auto">
                                            <p><a href="#">View Report </a></p>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-0">
                                        <div class="medicne d-flex">
                                            Hepatitis
                                        </div>
                                        <div class="medicne-time ml-auto">
                                            <p><a href="#">View Report </a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="solid-tab4">
                            <div class="tab-data">
                                <div class="tab-left">
                                    <div class="d-flex mb-3">
                                        <div class="medicne d-flex">
                                            Father
                                        </div>
                                        <div class="medicne-time ml-auto">
                                            <p>Charles Ortega </p>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-0">
                                        <div class="medicne d-flex">
                                            Mother
                                        </div>
                                        <div class="medicne-time ml-auto">
                                            <p>Julia Sims </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-right">
                                    <div class="d-flex mb-3">
                                        <div class="medicne d-flex">
                                            Siblings
                                        </div>
                                        <div class="medicne-time ml-auto">
                                            <p>Judy Clark </p>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-0">
                                        <div class="medicne d-flex">
                                            Spouse
                                        </div>
                                        <div class="medicne-time ml-auto">
                                            <p> Kyle </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="solid-tab5">
                            No Data Available
                        </div>
                        <div class="tab-pane" id="solid-tab6">
                            No Data Available
                        </div>
                        <div class="tab-pane" id="solid-tab7">
                            No Data Available
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
