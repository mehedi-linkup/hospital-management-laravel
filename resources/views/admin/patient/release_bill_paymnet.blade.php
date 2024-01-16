@extends('layouts.admin')
@section('title', 'Slip Bill')
@section('breadcrumb', 'Slip Bill')
@section('body')

<slip-bill-payment id="{{$id}}"   date = {{$date}}  role="{{ auth()->user()->role }}"></slip-bill-payment>

@endsection