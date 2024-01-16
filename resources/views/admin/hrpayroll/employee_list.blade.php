@extends('layouts.admin')
@section('title', 'Employee List')
@section('breadcrumb', 'Employee List')
@section('body')

<employee-list role="{{ auth()->user()->role }}"></employee-list>

@endsection