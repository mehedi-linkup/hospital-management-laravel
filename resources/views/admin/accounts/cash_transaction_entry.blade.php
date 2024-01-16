@extends('layouts.admin')
@section('title', 'Cash Transaction Entry')
@section('breadcrumb', 'Cash Transaction Entry')
@section('body')

<cash-transaction-entry role="{{ auth()->user()->role }}"></cash-transaction-entry>

@endsection
