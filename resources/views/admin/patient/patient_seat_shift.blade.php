@extends('layouts.admin')
@section('title', 'Patient Seat Shift')
@section('breadcrumb', 'Patient Seat Shift')
@section('body')

<patient-seat-shift role="{{ auth()->user()->role }}"></patient-seat-shift>

@endsection