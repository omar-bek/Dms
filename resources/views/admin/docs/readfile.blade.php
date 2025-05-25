@extends('layouts.dashboard')

@section('title')
    {{ __('roles.roles') }}
@endsection


@section('page_name')
    {{ __('roles.all_roles') }}
@endsection
@section('content')

{!! nl2br($text) !!}
    {{-- {{ nl2br($text) }} --}}

@endsection