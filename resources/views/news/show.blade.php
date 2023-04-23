@extends('admin.layouts.app')
@section('admin_content')
<div class="container" style="margin-top: 90px">
    <div>
        {{ $nw->title }}
    </div>
    <div>
        AAAA
    </div>
    <div>
        <?php echo htmlspecialchars_decode(htmlentities($nw->body)) ?>
    </div>
</div>
@endsection