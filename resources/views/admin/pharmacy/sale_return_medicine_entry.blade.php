@extends('layouts.admin')
@section('title', 'Medicine Sale Return Entry')
@section('breadcrumb', 'Medicine Sale Return Entry')
@section('body')

<sale-return-medicine-entry role="{{ auth()->user()->role }}" id={{$id}}></sale-return-medicine-entry>

@endsection