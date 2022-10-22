@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

        <div class="content container-fluid headbot">
            @if ($errors->any())
            @foreach ($errors->all() as $error)

                <div class="alert alert-danger" id="message">

                    <div style="text-align: center;">
                            <span >{{ $error }}</span>
                    </div>

                </div>
                @endforeach

            @endif
            @if (Session::has('message'))
            <div class="alert alert-primary" id="message">
                <div style="text-align: center;">

                        <span>{{ Session::get('message') }}</span>
                    </div>
            </div>
            @endif
            @if (Session::has('error'))
            <div class="alert alert-danger" id="message">
                <div style="text-align: center;">

                        <span>{{ Session::get('error') }}</span>
                    </div>
            </div>
            @endif

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <button id="showstore" type="submit" style="width:100%;" class="btn btn-success"> Mahsulot qo'shish </button>
                </div>
                <div class="col-md-12" id="forshowstore" style="display:none">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('product.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-4 col-sm-12">
                                        <input type="text" placeholder="Mahsulot nomini kiriting"  name="p_name" class="form-control form-control-sm"/>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6">
                                        <input type="number" placeholder="Miqdorini kiriting"  name="amount" class="form-control form-control-sm"/>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6">
                                        <select class="form-control form-control-sm" name='product_category_id'>
                                          <option value="" disabled selected hidden>O'lchamni tanlang</option>
                                            @foreach ($categories as $item)
                                                <option value='{{$item->id}}'>{{$item->cat_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6">
                                        <input type="number" placeholder="Miqdorini kodini kiriting"  name="code" class="form-control form-control-sm"/>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6">
                                        <select class="form-control form-control-sm" name='warehouse_id'>
                                          <option value="" disabled selected hidden>Skladni tanlang</option>
                                            @foreach ($warehouses as $item)
                                                <option value='{{$item->id}}'>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-4 col-sm-12">
                                            <button type="submit" style="width:100%;" class="btn btn-primary"> Saqlash </button>
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
                       <div class="card-body">
                          <div class="table-responsive">
                             <table class="table mb-0" id="forware">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Kodi</th>
                                        <th scope="col">Nomi</th>
                                        <th scope="col">Miqdori</th>
                                        <th scope="col">Sklad</th>
                                        <th scope="col">Harakat</th>
                                        <th scope="col">O'zgarish</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $key => $item)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$item->code}}</td>
                                            <td>{{$item->p_name}}</td>
                                            <td>{{$item->amount}} {{$item->category->cat_name}}</td>
                                            <td>{{$item->warehouse->name}}</td>
                                            <td>
                                                <button data-toggle="modal" data-target="#plus{{$item->id}}" type="submit"  class="btn btn-md btn-success mr-1"><i class="fas fa-plus mr-1"></i></button>
                                                <button data-toggle="modal" data-target="#minus{{$item->id}}" type="submit"  class="btn btn-md btn-danger"><i class="fas fa-minus mr-1"></i></button>
                                            </td>
                                            <td class="text-right">
                                                {{-- <a href="{{ route('product.edit',$item->id) }}" class="mr-1">
                                                <button type="submit"  class="btn btn-md btn-success"><i class="fas fa-edit mr-1"></i></button>
                                                    
                                                </a> --}}
                                                <a href="{{ route('product.trash',$item->id) }}">
                                                    <button type="submit"  class="btn btn-md btn-danger"><i class="fas fa-trash-alt mr-1"></i></button>
                                                        
                                                    </a>
                                             </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                             </table>
                          </div>
                       </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12 col-sm-12">
                    <button id="showstoretrash" type="submit" style="width:100%;" class="btn btn-primary"> Korzinka </button>
                </div>
                <div class="col-sm-12" id="forshowstoretrash" style="display:none">
                    <div class="card">
                       <div class="card-body">
                          <div class="table-responsive">
                             <table class="table mb-0" id="forware">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Kodi</th>
                                        <th scope="col">Nomi</th>
                                        <th scope="col">Miqdori</th>
                                        <th scope="col">Sklad</th>
                                        <th scope="col">O'zgarish</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($deletes as $key => $item)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$item->code}}</td>
                                            <td>{{$item->p_name}}</td>
                                            <td>{{$item->amount}} {{$item->category->cat_name}}</td>
                                            <td>{{$item->warehouse->name}}</td>
                                            <td class="text-right">
                                                <a href="{{ route('product.restore',$item->id) }}" class="mr-1">
                                                <button type="submit"  class="btn btn-md btn-success"><i class="fas fa-history mr-1"></i></button>
                                                    
                                                </a>
                                                <a href="{{ route('product.delete',$item->id) }}">
                                                    <button type="submit"  class="btn btn-md btn-danger"><i class="fas fa-trash-alt mr-1"></i></button>
                                                        
                                                    </a>
                                             </td>
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
    </div>
</div>
@foreach ($products as $key => $item)
<div class="modal fade" id="plus{{$item->id}}">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
    
        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">{{$item->p_name}}
            <div class="btn-group btn-group-sm ml-5">
                <button type="button" class="btn btn-outline-success">qo'shish</button>
            </div>
        </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form action="{{route('product.plus',$item->id)}}" method="post">
            @csrf
        <div class="modal-body">
                   <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="input-group">
                                <input oninvalid="InvalidMsg(this,'Miqdorni kiriting !');" 
                                oninput="InvalidMsg(this,'Miqdorni kiriting !');" type="number" required placeholder="Miqdorni kiriting"  name="plus" class="form-control form-control-md"/>
                            <div class="input-group-append">
                            <button type="button" class="btn btn-primary">{{$item->category->cat_name}}</button>
                            
                            </div>
                            </div>
                        </div>
                   </div>
            </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Saqlash</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
        </div>
        </form>

        
    </div>
    </div>
</div>
<div class="modal fade" id="minus{{$item->id}}">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
    
        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">{{$item->p_name}} 
            <div class="btn-group btn-group-sm ml-5">
                <button type="button" class="btn btn-outline-danger ">olish</button>
            </div>
        </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form action="{{route('product.minus',$item->id)}}" method="post">
            @csrf
        <div class="modal-body">
                   <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="input-group">
                                <input oninvalid="InvalidMsg(this,'Miqdorni kiriting !');" 
                                oninput="InvalidMsg(this,'Miqdorni kiriting !');" type="number" required placeholder="Miqdorni kiriting"  name="plus" class="form-control form-control-md"/>
                            <div class="input-group-append">
                            <button type="button" class="btn btn-primary">{{$item->category->cat_name}}</button>
                            
                            </div>
                            </div>
                        </div>
                   </div>
            </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Saqlash</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
        </div>
        </form>

        
    </div>
    </div>
</div>
@endforeach

@endsection
@section('admin_script')
   <script>
    $(document).ready(function(){
        // $("#forshowstore").hide();
        $("#showstore").click(function(){
            $("#forshowstore").slideToggle("slow");
        });

        $("#showstoretrash").click(function(){
            $("#forshowstoretrash").slideToggle("slow");
        });
    });
    function InvalidMsg(textbox,msg) {
        if (textbox.value === '') {
            textbox.setCustomValidity(msg);
        } else if (textbox.validity.typeMismatch){
            textbox.setCustomValidity('please enter a valid email address');
        } else {
           textbox.setCustomValidity('');
        }

        return true;
    }
   </script>
@endsection
