@extends('admin.layouts.app')
@section('admin_content')
   @livewire('mc-money',['begin' => $begin,'end' => $end])
@endsection
