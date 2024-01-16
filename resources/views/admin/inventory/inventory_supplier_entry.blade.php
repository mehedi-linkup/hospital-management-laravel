@extends('layouts.admin')
@section('title', 'Inventory Supplier Entry')
@section('breadcrumb', 'Inventory Supplier Entry')
@section('body')

<supplier-inventory-entry role="{{ auth()->user()->role }}"></supplier-inventory-entry>

@endsection