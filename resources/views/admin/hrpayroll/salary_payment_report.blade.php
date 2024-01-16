@extends('layouts.admin')
@section('title', 'Salary Payment Report')
@section('breadcrumb', 'Salary Payment Report')
@section('body')

<salary-payment-report role="{{ auth()->user()->role }}"></salary-payment-report>

@endsection