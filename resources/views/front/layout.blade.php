<!DOCTYPE html>
<html>
<head>
    @include('front.layout_partials.head')
</head>
<body>
    @include('front.layout_partials.header')
    <div class="wrapper">
        @yield('content')
    </div>

    @include('front.layout_partials.footer')
    @include('front.layout_partials.scripts')
</body>
</html>
