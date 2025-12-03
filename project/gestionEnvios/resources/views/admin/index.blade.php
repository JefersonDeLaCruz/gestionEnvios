@extends('layout.base-drawer')

@section('title', 'Home')

@section('content')
{{-- render del content --}}
@endsection

@section('sidebar')
    @include('layout.admin-sidebar')
@endsection

@section('footer')
    @include('layout.footer')
@endsection