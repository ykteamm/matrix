@extends('admin.layouts.app')
@section('admin_content')
<div class="content main-wrapper ">
   <div class="row gold-box">
      @include('admin.components.logo')

   </div>
   <div class="row headbot">
      <div class="col-sm-12">
         <div class="card mt-5">
            <div class="card-body">
                <div class="card-body">
                    <div class="table-responsive">
                       <table class="table mb-0 example1 table-bordered">
                          <thead>
                             <tr>
                                <th>Viloyat</th>
                                <th>Yanvar </th>
                                <th>Fevral</th>
                                <th>Mart</th>
                                <th>Aprel</th>
                                <th>May</th>
                                <th>Iyun</th>
                                <th>Iyul</th>
                                <th>Avgust</th>
                                <th>Sentabr</th>
                                <th>Oktabr</th>
                                <th>Noyabr</th>
                                <th>Dekabr</th>
                                <th>Jami</th>
                             </tr>
                          </thead>
                          <tbody>
                            @php
                                $fh = 0;
                                $fh2 = 0;

                            @endphp
                             @foreach ($regions as $k => $elchi)
                             <tr>
                                <td>{{$name[$elchi]}}</td>
                                @for ($i = 0; $i < 12; $i++)
                                <td>

                                    <p>
                                        <span class="badge badge-primary">{{number_format($reg[$elchi][$i], 0, ',', '.')}}</span>
                                    </p>
                                    <p>
                                        <span class="badge badge-success">{{ number_format($elchis[$elchi][$i], 0, ',', '.') }}</span>
                                    </p>

                                </td>
                                @endfor
                                <td>
                                    @php
                                        $fh = $fh + array_sum($reg[$elchi]);
                                        $fh2 = $fh2 + array_sum($elchis[$elchi]);
                                    @endphp
                                    <p>
                                        <span class="badge badge-primary">{{ number_format(array_sum($reg[$elchi]), 0, ',', '.')}}</span>
                                    </p>
                                    <p>
                                        <span class="badge badge-success">{{ number_format(array_sum($elchis[$elchi]), 0, ',', '.')}}</span>
                                    </p>
                                </td>
                             </tr>
                             @endforeach
                             <tr>
                                <td>Jami</td>

                                @for ($i = 0; $i < 12; $i++)
                                    @php
                                        $s = 0;
                                        $sh = 0;
                                    @endphp
                                    @foreach ($regions as $k => $elchi)
                                        @php
                                            $s = $s + $reg[$elchi][$i];
                                            $sh = $sh + $elchis[$elchi][$i];
                                        @endphp
                                    @endforeach
                                    <td>
                                        <p>
                                            <span class="badge badge-primary">{{number_format($s, 0, ',', '.')}}</span>
                                        </p>
                                        <p>
                                            <span class="badge badge-success">{{number_format($sh, 0, ',', '.')}}</span>
                                        </p>
                                    </td>
                                @endfor
                                <td>
                                    <p>
                                        <span class="badge badge-primary">{{number_format($fh, 0, ',', '.')}}</span>
                                    </p>
                                    <p>
                                        <span class="badge badge-success">{{number_format($fh2, 0, ',', '.')}}</span>
                                    </p>
                                </td>

                             </tr>
                             {{-- @foreach ($regions as $elchi)
                                @foreach ($reg[$elchi] as $sd)
                                    <tr>
                                        <td>{{$sd}}</td>
                                    </tr>
                                @endforeach
                             @endforeach --}}

                          </tbody>
                       </table>
                    </div>
                </div>
                </div>

         </div>
      </div>
   </div>
</div>
@endsection
@section('admin_script')
   <script>
   </script>
@endsection
