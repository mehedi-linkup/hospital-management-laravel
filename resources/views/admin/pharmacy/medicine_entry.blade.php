@extends('layouts.admin')
@section('title', 'Medicine Entry')
@section('breadcrumb', 'Medicine Entry')
@section('body')

<medicine-entry role="{{ auth()->user()->role }}"></medicine-entry>

@endsection