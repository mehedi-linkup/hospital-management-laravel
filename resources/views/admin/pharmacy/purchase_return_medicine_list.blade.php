@extends('layouts.admin')
@section('title', 'Purchase Return List')
@section('breadcrumb', 'Purchase Return List')
@section('body')

<purchase-return-medicine-list role="{{ auth()->user()->role }}"></purchase-return-medicine-list>

@endsection