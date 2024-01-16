@extends('layouts.admin')
@section('title', 'Agent Entry')
@section('breadcrumb', 'Agent Entry')
@section('body')

<agent-entry role="{{ auth()->user()->role }}"></agent-entry>

@endsection