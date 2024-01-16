@extends('layouts.admin')
@section('title', 'Appointment List')
@section('breadcrumb', 'Appointment List')
@section('body')

<appointment-list doctor_id="{{auth()->user()->doctor_id}}"></appointment-report>

@endsection