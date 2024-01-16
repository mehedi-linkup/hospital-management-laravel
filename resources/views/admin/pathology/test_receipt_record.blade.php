@extends('layouts.admin')
@section('title', 'Test Record')
@section('breadcrumb', 'Test Record')
@section('body')

<test-receipt-record role="{{ auth()->user()->role }}"></test-receipt-record>

@endsection