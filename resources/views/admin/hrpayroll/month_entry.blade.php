@extends('layouts.admin')
@section('title', 'Month Entry')
@section('breadcrumb', 'Month Entry')
@section('body')

<month-entry role="{{ auth()->user()->role }}"></month-entry>

@endsection