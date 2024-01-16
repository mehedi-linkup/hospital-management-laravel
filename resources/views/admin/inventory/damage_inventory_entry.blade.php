@extends('layouts.admin')
@section('title', 'Inventory Damage Entry')
@section('breadcrumb', 'Inventory Damage Entry')
@section('body')

<damage-inventory-entry role="{{ auth()->user()->role }}" code="{{ $code }}" branch="{{ auth()->user()->branch_id }}"></damage-inventory-entry>

@endsection