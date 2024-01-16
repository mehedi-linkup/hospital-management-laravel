@extends('layouts.admin')
@section('title', 'Salary Payment')
@section('breadcrumb', 'Salary Payment')
@section('body')

<salary-payment role="{{ auth()->user()->role }}" code={{ $code }}></salary-payment>

@endsection