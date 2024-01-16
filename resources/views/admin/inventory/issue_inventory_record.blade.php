@extends('layouts.admin')
@section('title', 'Inventory Issue Record')
@section('breadcrumb', 'Inventory Issue Record')
@section('body')

<issue-inventory-record role="{{ auth()->user()->role }}"></issue-inventory-record>

@endsection