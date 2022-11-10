@extends('admin.layouts.app')
@section('admin_content')
    <div class="row mt-5 pt-5">
        <div class="col-sm-12"
            <div class="card">
                <div class="card-body">
                    <form action="{{route('shablon.pharmacy.update',$shablon->id)}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="select" name="shablon_id" required >
                                        <option value="" disabled selected hidden></option>

                                        @foreach($shablons as $shab)
                                         @if($shab->id == $shablon->id)
                                         <option value="{{$shab->id}}" selected />{{$shab->name}}
                                         @else
                                         <option value="{{$shab->id}}"/>{{$shab->name}}

                                         @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header no-border">
                                        <h5 class="card-title">Dorixonalar ro'yhati </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped mb-0">
                                                <thead>
                                                <tr>
                                                    <th>No </th>
                                                    <th>Dorixona nomi </th>
                                                    <th>Region </th>
                                                    <th>Ruxsat berish </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($pharmacies as $pharmacy)
                                                <tr>
                                                    <td>{{$loop->index+1}} </td>
                                                    <td>{{$pharmacy->name}} </td>
                                                    <td>{{$pharmacy->region->name}} </td>
                                                    @if (in_array($pharmacy->id,$inarray))
                                                    <td> <input type="checkbox" id="horns" name="pharmacy_id[]" checked value="{{$pharmacy->id}}"></td>
                                                    @else
                                                    <td> <input type="checkbox" id="horns" name="pharmacy_id[]" value="{{$pharmacy->id}}"></td>

                                                    @endif
                                                    
                                                </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right " style="position: fixed;right: 1rem;top: 95vh; width: 100%"  >
                            <button type="submit" style="width: 83.5%;
                            " class="btn btn-primary">O'zgartirish </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            {{-- <div class="col-sm-12">
                <div class="card">
                   <div class="card-body">
                      <div class="table-responsive">
                         <table class="table mb-0" id="forware">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nomi</th>
                                    <th scope="col">Dorixona</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($shablons as $key => $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>
                                            @foreach ($item->shablon_pharmacy as $keys => $items)
                                                @isset($items->pharmacy_id)
                                                <span class="badge bg-info-light">{{$items->pharmacy->name}}</span>
                                                @endisset
                                            @endforeach
                                        </td>
                                        <td> 
                                            <a href="{{route('shablon.pharmacy.edit',$item->id)}}">
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> </button>
                                            </a> 
                                        <td>
                                    </tr>
                                @endforeach
                            </tbody>
                         </table>
                      </div>
                   </div>
                </div>
            </div> --}}
    </div>
@endsection
@section('admin_script')
<script>
</script>

@endsection

