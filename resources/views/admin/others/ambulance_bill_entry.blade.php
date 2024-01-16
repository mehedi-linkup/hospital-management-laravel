@extends('layouts.admin')
@section('title', 'Ambulance Bill Entry')
@section('breadcrumb', 'Ambulance Bill Entry')
@section('body')

<ambulance-bill-entry role="{{ auth()->user()->role }}" id={{$id}} code={{ $code }}></ambulance-bill-entry>

@endsection