@extends('layouts.admin')
@section('title', 'Driver Entry')
@section('breadcrumb', 'Driver Entry')
@section('body')

<drivers-entry role="{{ auth()->user()->role }}"></drivers-entry>

@endsection
