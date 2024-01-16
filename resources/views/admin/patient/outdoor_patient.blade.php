@extends('layouts.admin')
@section('title', 'Outdoor Patient')
@section('breadcrumb', 'Outdoor Patient')
@section('body')

<outdoor-patient role="{{ auth()->user()->role }}"></outdoor-patient>

@endsection