@extends('layouts.admin')
@section('title', 'Floor Entry')
@section('breadcrumb', 'Floor Entry')
@section('body')

<floor-entry role="{{ auth()->user()->role }}"></floor-entry>

@endsection
