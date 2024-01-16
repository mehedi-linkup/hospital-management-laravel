@extends('layouts.admin')
@section('title', 'Medicine Damage List')
@section('breadcrumb', 'Medicine Damage List')
@section('body')

<damage-medicine-list role="{{ auth()->user()->role }}" branch="{{ auth()->user()->branch_id }}"></damage-medicine-list>

@endsection