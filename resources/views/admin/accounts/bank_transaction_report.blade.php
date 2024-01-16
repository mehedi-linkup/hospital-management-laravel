@extends('layouts.admin')
@section('title', 'Bank Transaction Report')
@section('breadcrumb', 'Bank Transaction Report')
@section('body')

<bank-transaction-report role="{{ auth()->user()->role }}"></bank-transaction-report>

@endsection
