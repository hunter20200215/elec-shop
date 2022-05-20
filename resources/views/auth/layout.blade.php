<!DOCTYPE html>
<html>
<head>
    @include('admin.layout_partials.head')
</head>
<body>
<div class="auth-container">
    <div class="auth-box">
        <div class="auth-box-header">
            <div class="auth-box-header-text">@yield('title')</div>
            <img style="height:30px;width:30px" src="{{Storage::url($settings->logo)}}">
        </div>
        <div class="auth-box-content">
            @yield('content')
        </div>
    </div>
</div>

@include('admin.layout_partials.scripts')
</body>
</html>
