@extends('layouts.admin')
@section('title', 'Ambulance Entry')
@section('breadcrumb', 'Ambulance Entry')
@section('body')

<ambulance-entry role="{{ auth()->user()->role }}"></ambulance-entry>

@endsection