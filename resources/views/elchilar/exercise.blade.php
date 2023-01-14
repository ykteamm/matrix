@extends('admin.layouts.app')
@section('admin_content')
    <div class="content main-wrapper ">
        <div class="">
            @include('admin.components.logo')
            {{-- <div class="card flex-fill headbot">
       
               <div class="btn-group mr-5 ml-auto">
                  <div class="row">
                        <div class="col-md-12" align="center">
                                 Sana
                        </div>
                        <div class="col-md-12">
                           <button type="button" class="btn btn-block btn-outline-primary dropdown-toggle" id="age_button2" name="a_all"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Bugun </button>
                           <div class="dropdown-menu timeclass">
       
                           </div>
                        </div>
                  </div>
       
               </div>
               
                  
                --}}
            </div>

            <div class="row headbot">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                        <form action="{{route('elchi-battle-exercise-store')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label> Mahsulot </label>
                                        <select class="select" name="medicine_id" required>
                                        @foreach ($medicine as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label> Elexir </label>
                                        <input type="number" class="form-control form-control-lg" name="elexir" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label> Soni </label>
                                        <input type="number" class="form-control form-control-lg" name="number" required/>
                                    </div>
                                    <div class="form-group">
                                        <label> Ball </label>
                                        <select class="select" name="ball" required>
                                            <option value="0.1">0.1</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Qo'shish </button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('admin_script')
    <script>
    </script>
@endsection
