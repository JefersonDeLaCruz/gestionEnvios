@extends('layout.base-drawer')

@section('title', 'Home')
@section('content')

@if (Auth::user()->hasRole('admin'))
{{-- render del content --}}

@endif




@endsection
@section('sidebar')
    @include('layout.admin-sidebar')
@endsection
@section('footer')
    @include('layout.footer')
@endsection