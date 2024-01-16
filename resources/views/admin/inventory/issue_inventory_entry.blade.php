@extends('layouts.admin')
@section('title', 'Issue Entry')
@section('breadcrumb', 'Issue Entry')
@section('body')

<issue-inventory-entry role="{{ auth()->user()->role }}" invoice={{$invoice}} id={{$id}} branch="{{ auth()->user()->branch_id }}"></issue-inventory-entry>

@endsection