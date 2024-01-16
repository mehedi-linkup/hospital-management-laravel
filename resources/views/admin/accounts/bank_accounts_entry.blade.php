@extends('layouts.admin')
@section('title', 'Bank Account Entry')
@section('breadcrumb', 'Bank Account Entry')
@section('body')

<bank-accounts-entry role="{{ auth()->user()->role }}"></bank-accounts-entry>

@endsection
