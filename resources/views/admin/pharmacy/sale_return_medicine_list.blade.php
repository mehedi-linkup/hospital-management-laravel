@extends('layouts.admin')
@section('title', 'Sale Return List')
@section('breadcrumb', 'Sale Return List')
@section('body')

<sale-return-medicine-list role="{{ auth()->user()->role }}"></sale-return-medicine-list>

@endsection