@extends('layouts.admin')
@section('title', 'Doctor Entry')
@section('breadcrumb', 'Doctor Entry')
@section('body')

<doctor-entry role="{{ auth()->user()->role }}"></doctor-entry>

@endsection