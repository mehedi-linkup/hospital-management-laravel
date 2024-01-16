@extends('layouts.admin')
@section('title', 'Cash View')
@section('breadcrumb', 'Cash View')
@section('body')

<cash-view-report role="{{ auth()->user()->role }}"></cash-view-report>

@endsection
