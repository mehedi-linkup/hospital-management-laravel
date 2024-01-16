@extends('layouts.admin')
@section('title', 'Test Entry')
@section('breadcrumb', 'Test Entry')
@section('body')

<test-entry role="{{ auth()->user()->role }}"></test-entry>

@endsection