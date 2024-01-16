@extends('layouts.admin')
@section('title', 'Room Entry')
@section('breadcrumb', 'Room Entry')
@section('body')

<room-entry role="{{ auth()->user()->role }}"></room-entry>

@endsection
