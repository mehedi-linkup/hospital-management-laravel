@extends('layouts.admin')
@section('title', 'Bank Ledger')
@section('breadcrumb', 'Bank Ledger')
@section('body')

<bank-ledger-report role="{{ auth()->user()->role }}"></bank-ledger-report>

@endsection
