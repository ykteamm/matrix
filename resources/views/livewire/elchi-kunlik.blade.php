<div class="modal-content">

    @if ($resime == 2)
        

    <div class="modal-header">
        <h4 class="modal-title"> <img class="mr-2 mb-1" src="{{ $user->image_url }}"
            style="border-radius:50%" height="20px"> {{$user->last_name}} {{$user->first_name}}
        </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

        <div class="mt-3 ml-auto mr-5">
                <button class="btn btn-primary" onclick="$('#chartkunlik4').css('display','block');$('#chartkunlik6').css('display','none');">4oy</button>
                <button class="btn btn-primary" onclick="$('#chartkunlik4').css('display','none');$('#chartkunlik6').css('display','block');">6oy</button>
        </div>

        <div class="modal-body">
            <div id="chartkunlik4">

            </div>
            <div id="chartkunlik6">

            </div>
        </div>

        <div class="text-center mb-2">
            <a href="{{ route('elchi', ['id' => $ids, 'time' => 'today']) }}">
                <button class="btn btn-secondary">Ko'proq</button>
            </a>
        </div>

        

    @endif

    <script>
        $("#kunlikmodal").on('hide.bs.modal', function(){
            livewire.emit('change_resime');
        });
        var savdo4 = <?php echo json_encode($savdo4) ?>;
        var oy4 = <?php echo json_encode($oy4) ?>;
        var savdo6 = <?php echo json_encode($savdo6) ?>;
        var oy6 = <?php echo json_encode($oy6) ?>;

        var options4 = {
            series: [{
                name: 'Fakt',
                data: savdo4
            }],
            chart: {
                height: 350,
                type: 'area'
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                categories: oy4,
            },
            tooltip: {
                x: {},
            },
        };

        var options6 = {
            series: [{
                name: 'Fakt',
                data: savdo6
            }],
            chart: {
                height: 350,
                type: 'area'
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                categories: oy6,
            },
            tooltip: {
                x: {},
            },
        };

        var chart4 = new ApexCharts(document.querySelector("#chartkunlik4"), options4);
        chart4.render();
        var chart6 = new ApexCharts(document.querySelector("#chartkunlik6"), options6);
        chart6.render();
        $('#chartkunlik4').css('display','none');
    </script>
</div>