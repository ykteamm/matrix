<div>
    <style>
        .mc-danger{
            background: rgb(250, 137, 137)
        }
        .mc-danger-top{
            background: rgb(238, 79, 79)
        }
        .allmcbg{
            background: rgb(142, 204, 245)
        }
        
    </style>
    <div class="content container-fluid main-wrapper mt-5">
        <div class="row gold-box">
           @include('admin.components.logo')
           <div class="card flex-fill"> 
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0" id="dtBasicExample12333">
                            <thead>
                            <tr>
                                <th>Bron olish
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createBron">
                                        <i class="fas fa-plus" ></i>
                                    </button>
                                </th>
                                <th>Razgavor</th>
                                <th>Bron berish</th>
                                <th>Otgruzka</th>
                                <th>Pul kelishi</th>
                                <th>Zavod qarz</th>
                                <th>Otkaz</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>fff</td>
                                    <td>fff</td>
                                    <td>fff</td>
                                    <td>fff</td>
                                    <td>fff</td>
                                    <td>fff</td>
                                    <td>fff</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createBron">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bron yaratish</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('report-save') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label for="pharm-name">Pul miqdorini kiriting</label>
                        <input class="form-control" type="number" name="bron_puli" id="pharm-name">
                        <label>Vaqt kiriting</label>
                        <input class="form-control" type="date" name="date">
                        <ul class="list-group mt-2">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <select class="form-control form-control-sm" name='pharmacy_id' required>
                                        <option value="" disabled selected hidden>Apteka tanlang</option>
                                        @foreach ($pharmacy as $region)
                                            <option value='{{ $region->id }}'>
                                                {{ $region->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </ul>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Yaratish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
