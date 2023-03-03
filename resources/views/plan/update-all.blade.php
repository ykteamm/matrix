@extends('admin.layouts.app')
@section('admin_content')
    <form method="post" action="{{ route('plan.update-all-plans', ['id' => $user_id]) }}">
        @csrf
        <div class="container mt-5 pt-5" style="margin-top: 6% !important;">
            {{--        <a href="" class="btn btn-danger my-2 w-100">Orqaga</a> --}}

            <select class="form-select p-2 mb-2" aria-label="Default select example" name="shablon_id" required
                onchange="priceChange(this);">
                @php $i=1 @endphp
                @foreach ($shablons as $m)
                    @if ($m->id == 3)
                        <option value="{{ $m->id }}" selected>{{ $m->name }}</option>
                    @else
                        <option value="{{ $m->id }}">{{ $m->name }}</option>
                    @endif
                @endforeach
            </select>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Dori nomi</th>
                        <th scope="col">Oxirgi</th>
                        <th scope="col">Soni</th>
                        <th scope="col">Summasi</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($medicines as $medicine)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>{{ $medicine->name }}</td>
                            <td>
                                @if (isset($last_plans[$medicine->id]))
                                    {{ $last_plans[$medicine->id] }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                <input class="soni{{ $medicine->id }} form-control form-control-sm"
                                    onkeyup="inputPrice(this)"
                                    type="text" name="numbers.{{ $medicine->id }}" placeholder="Soni"
                                    value="{{ isset($current_plans[$medicine->id]) ? $current_plans[$medicine->id] : 0 }}"
                                    required
                                    >
                            </td>
                            @foreach ($price as $key => $item)
                                <td
                                    class="narx{{ $key }} narxcal{{ $key }}{{ $medicine->id }} allnarx @if ($key != 3) d-none @endif">
                                    {{ $price[$key][$medicine->id] }}
                                </td>
                                {{-- <td>
                            <input type="number" value="{{$price[3][$medicine->id]}}">
                        </td> --}}
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{--            <button type="submit" href="" class="btn btn-primary my-2 w-100">Saqlash</button> --}}

        </div>
        <div class="text-right " style="position: fixed;right: 1rem;top: 62px; width: 100%">
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" style="width: 66.5%;" class="btn btn-primary">Saqlash </button>

                </div>
                <div class="col-md-6">
                    <button type="button" id="forprice" style="width: 83.5%;" class="btn btn-primary">Plan summasi
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection
<style>
    .no-validated-input {
        border: 1px solid red;
    }
</style>
@section('admin_script')
    <script>
        function priceChange(id) {
            $('.allnarx').removeClass('d-none');
            $('.allnarx').addClass('d-none');
            $(`.narx${id.value}`).removeClass('d-none');

            var medId = <?php echo json_encode($medicines); ?>;
            var sum = 0;
            $.each(medId, function(index, value) {
                sum = sum + (parseInt($(`.narxcal${id.value}${value.id}`).html()) * parseInt($(`.soni${value.id}`)
                    .val()));
            });
            $('#forprice').text('Plan summasi: ' + sum);
        }

        function inputPrice(input) {
            if (Number(input.value) === 0) {} else if (Number(input.value) > 0) {} else {
                input.required = true;
                input.value = '';
            }

            var id = $('select[name="shablon_id"] option:selected').val();
            var medId = <?php echo json_encode($medicines); ?>;
            var sum = 0;
            $.each(medId, function(index, value) {
                var soni = $(`.soni${value.id}`).val();
                if (soni) {
                    var son = soni;
                } else {
                    var son = 0;
                }
                sum = sum + (parseInt($(`.narxcal${id}${value.id}`).html()) * parseInt(son));
            });

            $('#forprice').text('Plan summasi: ' + number_format(sum, 0, ',', '.'));
        }

        function number_format(number, decimals, dec_point, thousands_sep) {
            number = number.toFixed(decimals);

            var nstr = number.toString();
            nstr += '';
            x = nstr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? dec_point + x[1] : '';
            var rgx = /(\d+)(\d{3})/;

            while (rgx.test(x1))
                x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');
            return x1 + x2;
        }
    </script>
@endsection
