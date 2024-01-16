@extends('layouts.admin')
@section('title', 'Bill Entry')
@section('breadcrumb', 'Bill Entry')
@section('body')

<bill-entry role="{{ auth()->user()->role }}" code="{{$code}}" id="{{ $id }}"></bill-entry>

@endsection