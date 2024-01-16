@extends('layouts.admin')
@section('title', 'Patient Entry')
@section('breadcrumb', 'Patient Entry')
@section('body')

<patient-entry role="{{ auth()->user()->role }}"></patient-entry>

@endsection