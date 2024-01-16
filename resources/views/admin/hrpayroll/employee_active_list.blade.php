@extends('layouts.admin')
@section('title', 'Employee Active List')
@section('breadcrumb', 'Employee Active List')
@section('body')

<employee-active-list role="{{ auth()->user()->role }}"></employee-active-list>

@endsection