@extends('layouts.admin')
@section('title', 'Medicine Unit Entry')
@section('breadcrumb', 'Medicine Unit Entry')
@section('body')

<unit-medicine role="{{ auth()->user()->role }}"></unit-medicine>

@endsection