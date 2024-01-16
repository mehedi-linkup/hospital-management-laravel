@extends('layouts.admin')
@section('title', 'Brand Entry')
@section('breadcrumb', 'Brand Entry')
@section('body')

<brand-entry role="{{ auth()->user()->role }}"></brand-entry>

@endsection