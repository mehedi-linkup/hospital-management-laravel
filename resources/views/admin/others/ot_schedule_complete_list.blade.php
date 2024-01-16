@extends('layouts.admin')
@section('title', 'OT Schedule Complete List')
@section('breadcrumb', 'OT Schedule Complete List')
@section('body')


<ot-schedule-complete-list role="{{ auth()->user()->role }}"></ot-schedule-complete-list>

@endsection