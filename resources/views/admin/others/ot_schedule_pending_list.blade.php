@extends('layouts.admin')
@section('title', 'OT Schedule Pending List')
@section('breadcrumb', 'OT Schedule Pending List')
@section('body')


<ot-schedule-pending-list role="{{ auth()->user()->role }}"></ot-schedule-pending-list>

@endsection