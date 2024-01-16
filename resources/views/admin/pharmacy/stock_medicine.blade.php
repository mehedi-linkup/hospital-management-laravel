@extends('layouts.admin')
@section('title', 'Medicine Current Stock')
@section('breadcrumb', 'Medicine Stock')
@section('body')

<stock-medicine role="{{ auth()->user()->role }}"></stock-medicine>

@endsection