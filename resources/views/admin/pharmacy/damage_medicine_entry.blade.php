@extends('layouts.admin')
@section('title', 'Medicine Damage Entry')
@section('breadcrumb', 'Medicine Damage Entry')
@section('body')


<damage-medicine-entry role="{{ auth()->user()->role }}" code="{{ $code }}" branch="{{ auth()->user()->branch_id }}"></damage-medicine-entry>

@endsection