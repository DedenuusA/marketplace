@include('templatemarket.head')
@stack('css')

<body>

    <!-- ======= Header ======= -->
    @include('templatemarket.navbar')

    @yield('content')

    @include('templatemarket.footer')

    @include('templatemarket.scripts')

</body>

@stack('js')
