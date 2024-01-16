@extends('layouts.admin')
@section('title', 'Instrument Entry')
@section('breadcrumb', 'Instrument Entry')
@section('body')

<instrument-entry role="{{ auth()->user()->role }}"></instrument-entry>

@endsection