@extends('admin.layouts.app')
@section('admin_content')
@isset(Session::get('per')['dash'])
    @if(Session::get('per')['dash'] == 'true')
    <livewire:all-medicine-page />
    @endif
@endisset
@endsection
@section('admin_script')
@endsection
