@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

      <div class="content container-fluid headbot">
        <div class="month">      
            <ul>
              <li class="prev"><a href="{{route('setting',['month' => $minusmonth])}}" type="button" class="btn btn-outline-info">&#10094;</a></li>
              <li class="next"><a href="{{route('setting',['month' => $plusmonth])}}" type="button" class="btn btn-outline-info">&#10095;</a></li>
              <li>
                {{$monthname}}<br>
                <span style="font-size:18px" id="getym">{{$month}}</span>
              </li>
            </ul>
          </div>
          
          <ul class="weekdays">
            <li>Dushanba</li>
            <li>Seshanba</li>
            <li>Chorshanba</li>
            <li>Payshanba</li>
            <li>Juma</li>
            <li>Shanba</li>
            <li>Yakshanba</li>
          </ul>
          
          <ul class="days">
            @for($i=1;$i<=$key;$i++)
            <li></li>
            @endfor
                  @if ($ym_json == 1)
                    
            @foreach ($dates as $key => $item)
                     
                @if ($item == 'Monday')
                    <li><button type="button" class="btn btn-outline-info @if($ym_json == 1) blueday @else @if($ym_json[$key] == true) blueday @else redday @endif @endif" id="day{{$key}}" onclick="daySet(`day{{$key}}`)">{{$key}}</button></li>
                @elseif($item == 'Tuesday')
                    <li><button type="button" class="btn btn-outline-info blueday" id="day{{$key}}" onclick="daySet(`day{{$key}}`)">{{$key}}</button></li>
                    @elseif($item == 'Wednesday')
                    <li><button type="button" class="btn btn-outline-info blueday" id="day{{$key}}" onclick="daySet(`day{{$key}}`)">{{$key}}</button></li>
                    @elseif($item == 'Thursday')
                    <li><button type="button" class="btn btn-outline-info blueday" id="day{{$key}}" onclick="daySet(`day{{$key}}`)">{{$key}}</button></li>
                    @elseif($item == 'Friday')
                    <li><button type="button" class="btn btn-outline-info blueday" id="day{{$key}}" onclick="daySet(`day{{$key}}`)">{{$key}}</button></li>
                    @elseif($item == 'Saturday')
                    <li><button type="button" class="btn btn-outline-info blueday" id="day{{$key}}" onclick="daySet(`day{{$key}}`)">{{$key}}</button></li>
                    @elseif($item == 'Sunday')
                    <li><button type="button" class="btn btn-outline-info blueday" id="day{{$key}}" onclick="daySet(`day{{$key}}`)">{{$key}}</button></li>
                @endif
            @endforeach
            @else
            @foreach ($dates as $key => $item)
                     
                @if ($item == 'Monday')
                    <li><button type="button" class="btn @if($ym_json[$key] == 'true') btn-outline-info @else btn-danger @endif">{{$key}}</button></li>
                @elseif($item == 'Tuesday')
                    <li><button type="button" class="btn @if($ym_json[$key] == 'true') btn-outline-info @else btn-danger @endif">{{$key}}</button></li>
                    @elseif($item == 'Wednesday')
                    <li><button type="button" class="btn @if($ym_json[$key] == 'true') btn-outline-info @else btn-danger @endif">{{$key}}</button></li>
                    @elseif($item == 'Thursday')
                    <li><button type="button" class="btn @if($ym_json[$key] == 'true') btn-outline-info @else btn-danger @endif">{{$key}}</button></li>
                    @elseif($item == 'Friday')
                    <li><button type="button" class="btn @if($ym_json[$key] == 'true') btn-outline-info @else btn-danger @endif">{{$key}}</button></li>
                    @elseif($item == 'Saturday')
                    <li><button type="button" class="btn @if($ym_json[$key] == 'true') btn-outline-info @else btn-danger @endif">{{$key}}</button></li>
                    @elseif($item == 'Sunday')
                    <li><button type="button" class="btn @if($ym_json[$key] == 'true') btn-outline-info @else btn-danger @endif">{{$key}}</button></li>
                @endif
            @endforeach
            @endif
          </ul>
          <div class="d-flex align-items-center">
            @if ($ym_json == 1)
            <button type="button" class="btn btn-primary m-auto" onclick="save()">Saqlash</button>
            @else 
            {{-- <button type="button" class="btn btn-primary m-auto" onclick="save()">Saqlash</button> --}}
            @endif
          </div>
    </div>
    </div>

   </div>
@endsection
@section('admin_script')
   <script>
    function dataHref()
    {
      $(this).data("href");

    }
        function daySet(text)
        {
            $(`#${text}`).removeClass('btn-outline-info');
            $(`#${text}`).addClass('btn-danger');

            $(`#${text}`).removeClass('blueday');
            $(`#${text}`).addClass('redday');
        }
        function save()
        {
            var work_day = $('button.blueday').length;
            var year_month = $('#getym').text();
            var _token   = $('meta[name="csrf-token"]').attr('content');
            var day_json = [];
            $('button.blueday').each(function(element) {
                day_json[$(this).text()] = true
            });
            $('button.redday').each(function(element) {
                day_json[$(this).text()] = false
            });
         $.ajax({
            url: "/calendar",
            type:"POST",
            data:{
                day_json:day_json,
                year_month:year_month,
                work_day:work_day,
               _token: _token
            },
            success:function(response){
                
            }});
        }
   </script>
@endsection
