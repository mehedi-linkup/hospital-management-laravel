@extends('layouts.admin')
@section('title', 'Bill Type Entry')
@section('breadcrumb', 'Bill Type Entry')
@section('body')

<billtype-entry role="{{ auth()->user()->role }}"></billtype-entry>

@endsection