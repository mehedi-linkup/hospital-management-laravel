@extends('layouts.admin')
@section('title', 'Patient List')
@section('breadcrumb', 'Patient List')
@section('body')

<patient-list role="{{ auth()->user()->role }}"></patient-list>

@endsection