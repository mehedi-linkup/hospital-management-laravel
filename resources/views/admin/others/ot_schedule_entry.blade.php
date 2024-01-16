@extends('layouts.admin')
@section('title', 'OT Schedule Entry')
@section('breadcrumb', 'OT Schedule Entry')
@section('body')


<ot-schedule-entry role="{{ auth()->user()->role }}" code="{{ $code }}"></ot-schedule-medicine-entry>

@endsection