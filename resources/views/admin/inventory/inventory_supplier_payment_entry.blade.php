@extends('layouts.admin')
@section('title', 'Supplier Due Collection')
@section('breadcrumb', 'Supplier Due Collection')
@section('body')

<supplier-payment-inventory role="{{ auth()->user()->role }}"></supplier-payment-inventory>

@endsection