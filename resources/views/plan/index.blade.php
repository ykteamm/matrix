@extends('admin.layouts.app')
@section('admin_content')
    <div class="container pt-5">
        <a href="" class="btn btn-success my-2 w-100">Tahrirlash</a>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Dori nomi</th>
                <th scope="col">soni</th>
            </tr>
            </thead>
            <tbody>

            @foreach($medicines as $medicine)
                <tr>
                    <th scope="row">{{$loop->index+1}}</th>
                    <td>{{$medicine->name}}</td>
                    @php
                        $count=0;
                        $number=0;
                            foreach($plans as $plan){
                                if ($medicine->id==2 && $count==0){
                                    $number=$plan->number;
                                    $count=1;
                                    break;
                                }
                                }
                    @endphp

                    <td>{{$number}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection