@extends('layouts.admin')
@section('title', 'Inventory Purchase Returns')
@section('breadcrumb', 'Inventory Purchase Returns')
@section('body')



<purchase-inventory-returns role="{{ auth()->user()->role }}" id={{$id}}></purchase-inventory-returns>

@endsection