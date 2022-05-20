<!DOCTYPE html>
<html>
<head>
    @include('admin.layout_partials.head')
</head>
<body class="hold-transition skin-green fixed sidebar-mini">

    @include('admin.layout_partials.header')
    <div class="wrapper">
        @yield('content')
    </div>
@include('admin.layout_partials.scripts')
</body>
</html>
