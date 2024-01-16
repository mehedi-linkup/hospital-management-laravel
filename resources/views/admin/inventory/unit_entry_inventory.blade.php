@extends('layouts.admin')
@section('title', 'Inventory Unit Entry')
@section('breadcrumb', 'Inventory Unit Entry')
@section('body')

<unit-inventory role="{{ auth()->user()->role }}"></unit-inventory>


@endsection