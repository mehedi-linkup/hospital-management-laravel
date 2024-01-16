@extends('layouts.admin')
@section('title', 'Supplier Due List')
@section('breadcrumb', 'Supplier Due List')
@section('body')

<supplier-due-report role="{{ auth()->user()->role }}"></supplier-due-report>

@endsection
