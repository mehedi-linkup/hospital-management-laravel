@extends('layouts.admin')
@section('title', 'Purchase Return List')
@section('breadcrumb', 'Purchase Return List')
@section('body')

<purchase-return-inventory-list role="{{ auth()->user()->role }}"></purchase-return-inventory-list>

@endsection