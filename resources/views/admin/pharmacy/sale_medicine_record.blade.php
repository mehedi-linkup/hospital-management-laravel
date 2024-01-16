@extends('layouts.admin')
@section('title', 'Medicine Sale Record')
@section('breadcrumb', 'Medicine Sale Record')
@section('body')

<sale-medicine-record role="{{ auth()->user()->role }}"></sale-medicine-record>

@endsection