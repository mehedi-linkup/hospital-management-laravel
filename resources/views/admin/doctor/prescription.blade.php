@extends('layouts.admin')
@section('title', 'Prescription')
@section('breadcrumb', 'Prescription')
@section('body')

<prescription code="{{$code}}" id="{{$id}}"></prescription>

@endsection