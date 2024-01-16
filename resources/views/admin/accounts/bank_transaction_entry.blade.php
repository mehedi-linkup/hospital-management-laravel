@extends('layouts.admin')
@section('title', 'Bank Transaction Entry')
@section('breadcrumb', 'Bank Transaction Entry')
@section('body')

<bank-transaction-entry role="{{ auth()->user()->role }}"></bank-transaction-entry>

@endsection
