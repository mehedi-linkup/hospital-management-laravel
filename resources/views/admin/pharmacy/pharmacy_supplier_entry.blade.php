@extends('layouts.admin')
@section('title', 'Medicine Supplier Entry')
@section('breadcrumb', 'Medicine Supplier Entry')
@section('body')

<supplier-pharmacy-entry role="{{ auth()->user()->role }}"></supplier-pharmacy-entry>

@endsection