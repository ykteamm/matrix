@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

   </div>
   <div class="row headbot">
      <div class="col-sm-12">
         <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                    <tr>
                        <th>FIO </th>
                        <th>Telefon</th>
                        <th>Viloyat </th>
                        <th>Tuman </th>
                        <th>Xolati </th>
                        <th>Harakat </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($rekruts as $rekrut)
                    <form action="{{route('rekrut.check',$rekrut->id)}}" id="rekrutform{{$rekrut->id}}" method="POSt">
                        @csrf
                        <tr>
                            <td>{{$rekrut->fname}} </td>
                            <td>{{$rekrut->phone}} </td>
                            <td>{{$rekrut->r}} </td>
                            <td>{{$rekrut->d}} </td>
                            <td>
                                @if ($rekrut->status == 0)
                                    <span>Ko'rilmagan</span>
                                @elseif ($rekrut->status == 1)
                                    <span>Tasdiqlangan</span>
                                @else
                                    <span>Tasdiqlanmagan</span>
                                @endif
                            </td>

                            @if ($rekrut->status == 0)
                                <td class="rekrutbutton">
                                    <button class="btn" type="button" onclick="rekrutSuccess({{$rekrut->id}})"><span class="badge badge-success"><i class="fas fa-check"></i></span></button>
                                    <button class="btn" type="button" onclick="rekrutCancel({{$rekrut->id}})"><span class="badge badge-danger"><i class="fas fa-window-close"></i></span></button>
                                </td>
                                <td class="d-none rekrutbutton2">
                                    <button class="btn" ><span class="badge badge-success">Biroz kuting</span></button>
                                </td>

                            @endif

                        </tr>
                        @if ($rekrut->status != 0)

                        <tr>
                            <td colspan="5" class="text-center">
                                <textarea id="rekruting{{$rekrut->id}}" name="comment" disabled rows="3" cols="120">
                                    {{$rekrut->comment}}</textarea>
                            </td>

                        </tr>
                        @else
                        <tr>
                            <td colspan="6" class="text-center">
                                <textarea id="rekruting{{$rekrut->id}}" name="comment" rows="3" cols="120" placeholder="Sababini yozing..."></textarea>
                            </td>

                        </tr>
                        @endif

                        <input class="d-none rekrutinput{{$rekrut->id}}" type="number" name="status">
                    </form>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
      </div>
   </div>
</div>
@endsection
@section('admin_script')
   <script>
    function rekrutSuccess(id)
    {
        var comment = $(`#rekruting${id}`).val();

        if(comment.length > 5)
        {
            $('.rekrutbutton').addClass('d-none');
            $('.rekrutbutton2').removeClass('d-none');
            $(`.rekrutinput${id}`).val(1);
            $(`#rekrutform${id}`).submit();
        }

    }
    function rekrutCancel(id)
    {
        var comment = $(`#rekruting${id}`).val();

        if(comment.length > 5)
        {
            $('.rekrutbutton').addClass('d-none');
            $('.rekrutbutton2').removeClass('d-none');
            $(`.rekrutinput${id}`).val(2);
            $(`#rekrutform${id}`).submit();
        }

    }
    function districts()
    {
       var region = $('#aioConceptName').find(":selected").val();
       $('.aioConceptNameDist').addClass('d-none');
       $(`.distreg${region}`).removeClass('d-none');
    }
   </script>
@endsection
