@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

      <div class="content container-fluid headbot">
        <div class="month">      
            <ul>
              <li class="prev">&#10094;</li>
              <li class="next">&#10095;</li>
              <li>
                September<br>
                <span style="font-size:18px" id="getym">09.2022</span>
              </li>
            </ul>
          </div>
          
          <ul class="weekdays">
            <li>Mo</li>
            <li>Tu</li>
            <li>We</li>
            <li>Th</li>
            <li>Fr</li>
            <li>Sa</li>
            <li>Su</li>
          </ul>
          
          <ul class="days">
            <li></li>  
                    <li></li>  
                    <li></li> 
            @foreach ($dates as $key => $item)
                     
                @if ($item == 'Monday')
                    <li><button type="button" class="btn btn-outline-info blueday" id="day{{$key}}" onclick="daySet(`day{{$key}}`)">{{$key}}</button></li>
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
          </ul>
          <div class="d-flex align-items-center">
            <button type="button" class="btn btn-primary m-auto" onclick="save()">Saqlash</button>
          </div>
    </div>
    </div>

   </div>
@endsection
@section('admin_script')
   <script>
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
