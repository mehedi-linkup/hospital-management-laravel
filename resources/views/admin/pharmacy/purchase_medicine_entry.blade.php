@extends('layouts.admin')
@section('title', 'Purchase Order Entry')
@section('breadcrumb', 'Purchase Order Entry')
@section('body')

<purchase-medicine-entry role="{{ auth()->user()->role }}" invoice={{$invoice}} id={{$id}} branch="{{ auth()->user()->branch_id }}"></purchase-medicine-entry>

@endsection