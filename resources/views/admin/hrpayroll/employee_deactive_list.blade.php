@extends('layouts.admin')
@section('title', 'Employee Deactive List')
@section('breadcrumb', 'Employee Deactive List')
@section('body')

<employee-deactive-list role="{{ auth()->user()->role }}"></employee-deactive-list>

@endsection