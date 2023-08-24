@extends('admin.layouts.app')
@section('admin_content')
    <div class="row mt-5 pt-5">
        <div class="col-sm-12">
            <div class="card" >
                <div class="card-header">
                    <h4 class="card-title row d-flex justify-content-between">  </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="ostatok-pharmacy-div"></div>
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-0" id="ostatok-pharmacy">
                                            <thead>
                                            <tr>
                                                <th>No </th>
                                                <th>Dorixona nomi </th>
                                                <th>Region </th>
                                                <th>Oxirig ostatka </th>
                                                <th>Taqqoslash </th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($pharmacy as $pharm)

                                                    <tr>
                                                        <td>{{$loop->index+1}} </td>
                                                        <td>{{$pharm['pharmacy']->name}} </td>
                                                        <td>{{$pharm['pharmacy']->region->name}} </td>
                                                        <td>
                                                            @if ($pharm['ostatok'])
                                                                {{date('d.m.Y',strtotime($pharm['ostatok']->created_at))}} 
                                                            @endif
                                                        </td>
                                                        <td> <a href="{{route('compare.pharm',['id'=>$pharm['pharmacy']->id,'time'=>date('Y-m')])}}">
                                                            <span class="badge badge-primary">Taqqoslash</span>
                                                        </a> </td>
                                                        {{-- <td>{{$pharm->region->name}}</td> --}}
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
    </div>
@endsection
