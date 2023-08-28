<div class="content container-fluid mt-5">
    <div class="page-header mt-5">
        <div class="row">
            <div class="card col-md-6">
                <div class="card-body" style="background: rgb(187 222 253);border-radius:5px;">
                    <div>
                        <h3 class="text-center">Pul kelishi</h3>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span><h3>{{numb($arrive_monay)}}</h3></span>
                        <span>
                            <h3 style="color:red">
                                {{numb($qarz['qizil_sumi'])}}
                                ({{($qarz['qizil_soni'])}})
                            </h3>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span><h3>{{numb($arrive_monay_day)}} bugun</h3></span>
                        <span>
                            <h3 style="color: rgb(215 167 25);">
                                {{numb($qarz['sariq_sumi'])}}
                                ({{($qarz['sariq_soni'])}})
                            </h3>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span><h3>{{numb($arrive_monay_week)}} hafta</h3></span>
                        <span>
                            <h3 style="color:rgb(17 139 24)">
                                {{numb($qarz['yashil_sumi'])}}
                                ({{($qarz['yashil_soni'])}})
                            </h3>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card col-md-6">
                <div class="card-body" style="background: rgb(187 222 253);border-radius:5px;">
                    <div>
                        <h3 class="text-center">Otgruzka</h3>
    
                    </div>
                    <div class="d-flex justify-content-between">
                        <span><h3>{{numb($shipment)}}</h3></span>
                        <span>
                            <h3 style="color:red">
                                {{numb($qizil_sum)}}
                                ({{($qizil)}})
                            </h3>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span><h3>{{numb($shipment_day)}} bugun</h3></span>
                        <span>
                            <h3 style="color: rgb(215 167 25);">
                                {{numb($sariq_sum)}}
                                ({{($sariq)}})
                            </h3>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span><h3>{{numb($shipment_week)}} hafta</h3></span>
                        <span>
                            <h3 style="color:rgb(17 139 24)">
                                ({{($yashil)}})
                            </h3>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
