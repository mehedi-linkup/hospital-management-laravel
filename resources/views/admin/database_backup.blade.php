@extends('layouts.admin')
@section('title', 'Database Backup')
@section('breadcrumb', 'Database Backup')
@push('css')
<style>
    .backup-button div {
        width:250px;height:120px;background:lightgreen;padding:25px;font-size:20px;color:#454545
    }
    .backup-button div:hover {
        background: lightblue;
    }
</style>
@endpush
@section('body')
<div class="row">
    <div class="col-md-12 text-center">
        <form action="{{route('database_backup')}}" method="post" style="margin-top:15%;">
            @csrf
            <button type="submit" name="submit" class="backup-button btn btn-success" style="border:none;padding:0px;">
                <div>
                    <i class="fa fa-database fa-2x"></i><br>
                    Backup Now</div>
            </button>
        </form>
    </div>
</div>
@endsection