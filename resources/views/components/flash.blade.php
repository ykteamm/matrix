@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{ $message }}</strong>
</div>
@endif
  
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{ $message }}</strong>
</div>
@endif
   
@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{ $message }}</strong>
</div>
@endif
   
@if ($message = Session::get('info'))
<div class="alert alert-info alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{ $message }}</strong>
</div>
@endif
  
@if ($errors->any())
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    Please check the form below for errors
</div>
@endif
$("#province").change(function(){
    var province = $("#province").val();
    if (province) {
        var district = {!! json_encode($district->toArray()) !!};
    
    $.each(district, function(key,val) {
        if(province == val['province_id']){
    $(`#${val['district_name']}${val['province_id']}`).css("display","");


        }
        else{
    $(`#${val['district_name']}${val['province_id']}`).css("display","none");

        }

    });
    }
    
    $("#place_dist").val('');
    $("#for_district").css("display","none");
    $("#district").css("display","");
});