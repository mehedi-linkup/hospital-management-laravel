@extends('layouts.admin')
@section('title', 'Test Receipt')
@section('breadcrumb', 'Test Receipt')
@section('body')

<test-receipt role="{{ auth()->user()->role }}" code={{ $code }} id={{ $id }}></test-receipt>

@endsection