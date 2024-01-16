@extends('layouts.admin')
@section('title', 'Generic Entry')
@section('breadcrumb', 'Generic Entry')
@section('body')

<generic-entry role="{{ auth()->user()->role }}"></generic-entry>

@endsection