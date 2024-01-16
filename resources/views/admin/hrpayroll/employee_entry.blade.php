@extends('layouts.admin')
@section('title', 'Employee Entry')
@section('breadcrumb', 'Employee Entry')
@section('body')

<employee-entry role="{{ auth()->user()->role }}"></employee-entry>

@endsection