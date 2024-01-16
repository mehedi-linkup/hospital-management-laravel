@extends('layouts.admin')
@section('title', 'Cash Ledger')
@section('breadcrumb', 'Cash Ledger')
@section('body')

<cash-ledger-report role="{{ auth()->user()->role }}"></cash-ledger-report>

@endsection
