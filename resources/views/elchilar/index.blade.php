@extends('admin.layouts.app')
@section('admin_content')
    <div class="card w-100 " style="overflow-y: scroll">
    <div class="card-header no-border">
        <h4 class="card-title float-left">Upcoming Appointments </h4>
        <span class="float-right"><a href="appointments.html">View all </a></span>
    </div>
    <div id="table-wrapper" class="card-body">
        <div id="table-scroll" class="table-responsive" style="height: 90vh; overflow-y: scroll">
            <table class="table mb-0 table-striped "  >
                <thead >
                <tr>
                    <th ><strong>ID</strong> </th>
                    <th><strong>Garb/Sharq</strong></th>
                    <th><strong>Viloyat</strong> </th>
                    <th><strong>Captain </strong></th>
                    <th><strong>Elchi</strong> </th>
                    <th><strong>Encane</strong> </th>
                    <th><strong>Plan </strong></th>
                    <th><strong>Kunlik plan </strong></th>
                    <th><strong>Fakt </strong></th>
                    <th><strong>Prognoz  </strong></th>
                    @foreach($days as $day)
                    <th onclick="open()"><strong>{{date('d.m.Y',strtotime($day))}}  </strong></th>

                    @endforeach

{{--                    <th class="text-right">Action </th>--}}
                </tr>
                </thead>
                <tbody  >
                @php $t=0; @endphp
                @foreach($elchilar as $item)
                    @if($item['elchi']->admin ==False)
                <tr>
                    <td>{{$t+1}} </td>
                    <td>@if($item['elchi']->v_name=='Namangan viloyati'||$item['elchi']->v_name=='Farg‘ona viloyati'||$item['elchi']->v_name=='Andijon viloyati'||$item['elchi']->v_name=='Toshkent viloyati'||$item['elchi']->v_name=='Toshkent shahri')Sharq @else G‘arb @endif </td>
                    <td>{{$item['elchi']->v_name}} </td>
                    <td>Captain </td>
                    <td>
                        <div>
                            <strong>
                                <img class="mr-2" src="{{$item['elchi']->image_url}}" style="border-radius:50%" height="20px"> {{ $item['elchi']->last_name}} {{$item['elchi']->first_name}} ( Elchi )
                            </strong>
                        </div>
                        <div>
                            <span class="badge bg-success-light">Ichki reyting:  <span class="text-danger">{{$item['ichki-reyting']}} </span> </span>
                            <span class="badge bg-primary-light">Tashqi reyting:  <span class="text-danger">{{$item['tashqi-reyting']}} </span></span>
                        </div>
                    </td>
                    <td>{{$encane[$t]}} </td>
                    <td><span class="badge bg-primary-light">{{number_format($plan[$t])}}</span> </td>
                    <td><span class="badge bg-success-light">{{number_format($plan_day[$t])}}</span> </td>
                    <td> <span class="badge bg-warning-light">{{$elchi_fact[$item['elchi']->id]}}</span></td>
                    <td> <span class="badge bg-success-light">{{$elchi_prognoz[$item['elchi']->id]}}</span></td>
                    @php $i=0; @endphp
                    @foreach($days as $day)
                    <td> {{ number_format($sold[$t][$i])}}</td>
                    @php $i++; @endphp
                    @endforeach
{{--                    <td class="text-right">--}}
{{--                        <a href="#" class="btn btn-sm btn-white text-success mr-2"><i class="far fa-edit mr-1"></i> Edit </a>--}}
{{--                        <a href="javascript:void(0);" class="btn btn-sm btn-white text-danger mr-2"><i class="far fa-trash-alt mr-1"></i>Delete </a>--}}
{{--                    </td>--}}
                </tr>
                @php $t++; @endphp

                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
    <script>

    </script>
@endsection
