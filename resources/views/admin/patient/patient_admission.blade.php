@extends('layouts.admin')
@section('title', 'Patient Admission')
@section('breadcrumb', 'Patient Admission')
@section('body')

<patient-admission role="{{ auth()->user()->role }}" code="{{ $code }}"></patient-admission>

@endsection