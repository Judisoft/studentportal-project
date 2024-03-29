<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Dashboard</title>
    <link rel="icon" href="{{ asset('backend/images/fav.html') }}" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="{{asset('backend/css/main.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/style.css')}}">
    {{-- <link rel="stylesheet" href="{{asset('css/uikit.min.css')}}"> --}}
    <link rel="stylesheet" href="{{asset('backend/css/color.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/responsive.css')}}">
	<link href="{{ asset('backend/plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- ck editor -->
    <script src="https://cdn.ckeditor.com/4.17.1/standard-all/ckeditor.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    
    @livewireStyles

    <!-- Scripts -->
    <script src="{{ asset('backend/js/app.js') }}" defer></script>
    <script src="{{ asset('backend/js/quiz.js') }}"></script>
</head>
<body>
{{-- <div class="page-loader" id="page-loader">
    <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
    <span>Loading...</span>
</div><!-- page loader --> --}}
    @yield('content')
    <div class="theme-layout">
        @include('layouts.dashboard.top-nav')
        @include('layouts.dashboard.side-nav')
    </div>
@livewireScripts
@yield('page_scripts')
<script src="{{asset('backend/js/main.min.js')}}"></script>
<script src="{{asset('backend/js/uikit.min.js')}}"></script>
<script src="{{asset('backend/js/sparkline.js')}}"></script>
<script src="{{asset('backend/js/chart.js')}}"></script>
<script src="{{asset('backend/js/vivus.min.js')}}"></script>
<script src="{{asset('backend/js/script.js')}}"></script>
<script src="{{ asset('backend/plugins/apex/apexcharts.min.js')}}"></script>
<script src="{{asset('backend/js/graphs-scripts.js')}}"></script>
</body>
</html>