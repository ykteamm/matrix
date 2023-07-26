<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>FIO </th>
                            <th>Crystal</th>
                            <th>Harakat</th>
                        </tr>
                        </thead>
                        <tbody>
                                @foreach ($user as $item)
                                    <tr class="table-primary">
                                        <td>{{$item->first_name}} {{$item->last_name}}
                                        </td>
                                        <td>{{ $crystal[$item->id] }}</td>
                                        <td> 
                                            <button class="btn btn-primary" onclick="$('.detail{{$item->id}}').toggle();"><i class="fas fa-eye"></i></button> 
                                        </td>
                                    </tr>

                                    @foreach ($detail[$item->id] as $det)
                                        <tr class="table-secondary detail{{$item->id}}" style="display: none;">
                                            <td class="text-center">{{$det->comment}}</td>
                                            <td>{{ $det->crystal }}</td>
                                            <td> 
                                                <button class="btn btn-danger" wire:click="$emit('delete', {{ $det->id }})"><i class="fas fa-trash"></i></button> 
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
