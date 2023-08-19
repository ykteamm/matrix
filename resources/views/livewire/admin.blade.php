<div class="content container-fluid mt-5">
    <div class="page-header mt-5">
        <div class="row">
            <div class="card col-md-4">
                <div class="card-body" style="background: rgb(191, 236, 148);border-radius:5px;">
                    <div>
                        <h3 class="text-center">Pul kelishi</h3>
                        <h3>{{numb($arrive_monay)}}</h3>
    
                        <h3>+{{numb($arrive_monay_day)}} bugun</h3>
                        <h3>{{numb($arrive_monay_week)}} hafta</h3>
    
                    </div>
                </div>
            </div>
            <div class="card col-md-4">
                <div class="card-body" style="background: rgb(171, 175, 238);border-radius:5px;">
                    <div>
                        <h3 class="text-center">Otgruzka</h3>
                        <h3>{{numb($shipment)}}</h3>
                        <h3>+{{numb($shipment_day)}} bugun</h3>
                        <h3>{{numb($shipment_week)}} hafta</h3>
    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
