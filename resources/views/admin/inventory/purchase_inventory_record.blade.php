@extends('layouts.admin')
@section('title', 'Inventory Purchase Record')
@section('breadcrumb', 'Inventory Purchase Record')
@section('body')

<purchase-inventory-record role="{{ auth()->user()->role }}"></purchase-inventory-record>

@endsection