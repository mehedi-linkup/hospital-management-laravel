@extends('layouts.admin')
@section('title', 'Inventory Category Entry')
@section('breadcrumb', 'Inventory Category Entry')
@section('body')

<category-inventory role="{{ auth()->user()->role }}"></category-inventory>

@endsection