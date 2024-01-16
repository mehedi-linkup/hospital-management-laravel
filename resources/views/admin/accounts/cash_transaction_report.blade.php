@extends('layouts.admin')
@section('title', 'Cash Transaction Report')
@section('breadcrumb', 'Cash Transaction Report')
@section('body')

<cash-transaction-report role="{{ auth()->user()->role }}"></cash-transaction-report>

@endsection
