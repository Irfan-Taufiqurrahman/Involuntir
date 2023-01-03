@extends('admin.layout.app')
@section('body')
    <div class="main-wrapper">
        @include('admin.layout.sidebar')

        <div class="page-wrapper">
            @include('admin.layout.navbar')
            <div class="page-content">
                @yield('content')
            </div>
        </div>
    </div>
@endsection
