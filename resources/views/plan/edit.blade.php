@extends('admin.layouts.app')
@section('admin_content')
    <div class="container pt-5">
{{--        <a href="" class="btn btn-danger my-2 w-100">Orqaga</a>--}}
        <form  method="post" action="{{route('plan.update',['id'=>$user_id])}}">
            @csrf
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
                                    if ($medicine->id==$plan->medicine_id && $count==0){
                                        $number=$plan->number;
                                        $count=1;
                                        break;
                                    }
                                    }
                        @endphp

                        <td>
                            <input type="number" name="numbers.{{$medicine->id}}"  value="0">
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="text-right " style="position: fixed;right: 1rem;top: 95vh; width: 100%"  >
                <button type="submit" style="width: 83.5%;" class="btn btn-primary">O'zgarishlarni saqlash </button>
            </div>
        </form>

    </div>
@endsection
