@extends('admin.layouts.app')
@section('admin_content')
   @livewire('mc-shipment',['order_id' => $order_id])
@endsection
