@extends('layouts.admin')
@section('title', 'Purchase Return Entry')
@section('breadcrumb', 'Purchase Return Entry')
@section('body')

<purchase-return-medicine-entry role="{{ auth()->user()->role }}" id={{$id}} ></purchase-return-medicine-entry>

@endsection