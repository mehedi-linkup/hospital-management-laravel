@extends('layouts.admin')
@section('title', 'Seat Entry')
@section('breadcrumb', 'Seat Entry')
@section('body')

<seat-entry role="{{ auth()->user()->role }}"></seat-entry>

@endsection
