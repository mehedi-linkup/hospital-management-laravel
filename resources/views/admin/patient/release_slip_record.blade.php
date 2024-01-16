@extends('layouts.admin')
@section('title', 'Release Slip Record')
@section('breadcrumb', 'Release Slip Record')
@section('body')

<release-slip-record  role="{{ auth()->user()->role }}"></release-slip-record>

@endsection