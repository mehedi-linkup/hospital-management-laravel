@extends('layouts.admin')
@section('title', 'Accounts Entry')
@section('breadcrumb', 'Accounts Entry')
@section('body')

<accounts-entry role="{{ auth()->user()->role }}"></accounts-entry>

@endsection
