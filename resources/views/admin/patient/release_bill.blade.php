@extends('layouts.admin')
@section('title', 'Release Slip')
@section('breadcrumb', 'Release Slip')
@section('body')

<release-bill id="{{$id}}" date="{{ $date }}"></release-bill>

@endsection