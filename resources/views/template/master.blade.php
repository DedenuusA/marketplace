@include('template.head')
@stack('css')

<body>

    <!-- ======= Header ======= -->
    @include('template.navbar')

    <!-- ======= Sidebar ======= -->
    @include('template.sidebar')

    @yield('content')

    @include('template.footer')

    @include('template.scripts')

</body>

@stack('js')
