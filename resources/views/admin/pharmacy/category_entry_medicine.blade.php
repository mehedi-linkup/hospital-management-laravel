@extends('layouts.admin')
@section('title', 'Medicine Category Entry')
@section('breadcrumb', 'Medicine Category Entry')
@section('body')

<category-medicine role="{{ auth()->user()->role }}"></category-medicine>

@endsection