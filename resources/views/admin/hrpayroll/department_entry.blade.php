@extends('layouts.admin')
@section('title', 'Department Entry')
@section('breadcrumb', 'Department Entry')
@section('body')

<department-entry role="{{ auth()->user()->role }}"></department-entry>

@endsection