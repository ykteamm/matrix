<div class="table-responsive">

    <table class="table mb-0 " id="dtBasicExample12">
        <thead>
            <tr>
                <th>Viloyat</th>
                <th>Ismi</th>
                <th>Familiyasi </th>
                <th>Soni </th>
            </tr>
        </thead>

        <tbody>

            @php
                $sum = 0;
            @endphp
            @foreach ($king_solds as $item)
                @php
                    $sum += $item->count;
                @endphp
                <tr>
                    <td>{{ $item->r }} </td>
                    <td>{{ $item->f }} </td>
                    <td>{{ $item->l }} </td>
                    <td>{{ $item->count }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-right">
        <h2>Jami:{{ $sum }}</h2>

    </div>

</div>


<table class="table mb-0">
    <thead>
        <tr>
            <th>Viloyat</th>
            <th></th>
            <th></th>
            <th>Sone</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($regions as $key => $item)
            <div class="card">
                <div class="card-header" id="headingOne{{ $item->id }}">
                    <h2 class="mb-0">
                        <button class="btn btn-block text-left" type="button" data-toggle="collapse"
                            data-target="#collapseOne{{ $item->id }}" aria-expanded="true"
                            aria-controls="collapseOne{{ $item->id }}">
                            {{ $item->name }}
                        </button>
                    </h2>
                </div>

                <div id="collapseOne{{ $item->id }}" class="collapse"
                    aria-labelledby="headingOne{{ $item->id }}" data-parent="#accordionExample">
                    <div class="card-body">

                    </div>
                </div>
            </div>
        @endforeach
    </tbody>
</table>

















<table class="table mb-0 " id="dtBasicExample12">
    <thead>
        <tr>
            <th>Viloyat</th>
            <th>Ismi</th>
            <th>Familiyasi </th>
            <th>Soni </th>
        </tr>
    </thead>
    @php
        $total = [];
        foreach ($regions as $reg) {
            foreach ($king_solds as $king) {
                if ($reg == $king->r) {
                    if (!isset($total[$reg])) {
                        $total[$reg] = [];
                    }
                    $total[$reg][] = $king->r;
                }
            }
        }
    @endphp
    <tbody>
        @php
            $region->$idd = 0;
        @endphp
        @foreach ($total as $key => $regions)
            @php
                $idd += 1;
            @endphp
            <div class="accordion" id="accordion{{ $idd }}">
                <div class="card">
                    <div class="card-header" id="heading{{ $idd }}">
                        <h2 class="mb-0">
                            <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse"
                                data-target="#collapseThree{{ $idd }}" aria-expanded="false"
                                aria-controls="collapseThree{{ $idd }}">
                                {{ $key }}
                            </button>
                        </h2>
                    </div>
                    <div id="collapseThree{{ $idd }}" class="collapse"
                        aria-labelledby="heading{{ $idd }}" data-parent="#accordion{{ $idd }}">
                        <div class="card-body">
                            And lastly, the placeholder content for the third and final accordion panel. This panel is
                            hidden by default.
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </tbody>















































    <div class="table-responsive">
        <table class="table mb-0 " id="dtBasicExample12">
            <thead>
                <tr>
                    <th>Viloyat</th>
                    <th>Ismi</th>
                    <th>Familiyasi </th>
                    <th>Soni </th>
                </tr>
            </thead>

            <tbody>

                @php
                    $sum = 0;
                @endphp
                @foreach ($regions as $item)
                    @php
                        $sum += $item->count;
                    @endphp
                    <tr>
                        <td>{{ $item->r }} </td>
                        <td>{{ $item->f }} </td>
                        <td>{{ $item->l }} </td>
                        <td>{{ $item->count }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-right">
            <h2>Jami:{{ $sum }}</h2>
        </div>
    </div>
