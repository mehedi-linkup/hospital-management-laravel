@extends('layouts.admin')
@section('title', 'Designation Entry')
@section('breadcrumb', 'Designation Entry')
@section('body')

<designation-entry role="{{ auth()->user()->role }}"></designation-entry>

@endsection