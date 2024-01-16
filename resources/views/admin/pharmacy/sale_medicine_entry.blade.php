@extends('layouts.admin')
@section('title', 'Medicine Sale Entry')
@section('breadcrumb', 'Medicine Sale Entry')
@section('body')

<sale-medicine-entry role="{{ auth()->user()->role }}" invoice={{$invoice}} id={{$id}} branch="{{ auth()->user()->branch_id }}"></sale-medicine-entry>

@endsection