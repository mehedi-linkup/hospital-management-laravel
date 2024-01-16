@extends('layouts.admin')
@section('title', 'Medicine Purchase Record')
@section('breadcrumb', 'Medicine Purchase Record')
@section('body')

<purchase-medicine-record role="{{ auth()->user()->role }}"></purchase-medicine-record>

@endsection