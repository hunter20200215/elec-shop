<header class="main-header">
    <nav class="navbar" role="navigation">
        <a href="{{ route('admin.dashboard') }}" class="navbar-item"><div class="navbar-item-text">@lang('admin.Welcome')</div></a>
        <div class="navbar-item-wrapper">
            <a href="{{route('admin.orders.index')}}" class="navbar-item @if($menu == 'orders') navbar-item-active @endif"><div class="navbar-item-text">@lang('admin.Orders')</div></a>
            <a href="{{route('admin.users.index') . '?signups' }}" class="navbar-item @if($menu == 'customers') navbar-item-active @endif"><div class="navbar-item-text">@lang('admin.SignUPs')</div></a>
            <a href="{{route('admin.products.index')}}" class="navbar-item @if($menu == 'products') navbar-item-active @endif"><div class="navbar-item-text">@lang('admin.Products')</div></a>
            <a href="{{route('admin.pages.index')}}" class="navbar-item @if($menu == 'pages') navbar-item-active @endif"><div class="navbar-item-text">@lang('admin.Pages')</div></a>
            <a href="{{route('admin.attributes.index')}}" class="navbar-item @if($menu == 'attributes' || $menu == 'attribute_values') navbar-item-active @endif"><div class="navbar-item-text">@lang('admin.Attributes')</div></a>
            <a href="{{route('admin.categories.index')}}" class="navbar-item @if($menu == 'categories') navbar-item-active @endif"><div class="navbar-item-text">@lang('admin.Categories')</div></a>
            <div class="btn-group navbar-item @if(in_array($menu, ['settings', 'users', 'permissions', 'roles'])) navbar-item-active @endif">
                <a href="{{route('admin.settings.index')}}"><button type="button" style="box-shadow: none; height: 100%" class="btn navbar-item-text @if($menu == 'settings') navbar-item-active @endif">@lang('admin.Settings')</button></a>
                <button type="button" style="box-shadow: none;color:#777777" class="btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item @if($menu == 'users') navbar-item-active @endif" href="{{route('admin.users.index')}}">@lang('admin.Users')</a></li>
                    <li><a class="dropdown-item @if($menu == 'permissions') navbar-item-active @endif" href="{{route('admin.permissions.index')}}">@lang('admin.Permissions')</a></li>
                    <li><a class="dropdown-item @if($menu == 'roles') navbar-item-active @endif" href="{{route('admin.roles.index')}}">@lang('admin.Roles')</a></li>
                </ul>
            </div>
        </div>
        <a class="navbar-item" style="font-size: 30px; display: flex; justify-content: center; align-items: center; width: auto; height: auto" href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </nav>
</header>
<header class="mobile-header">
    <div class="collapse" id="navbarToggleExternalContent">
        <div style="background-color: #eeeff1!important;">
            <a href="{{ route('admin.dashboard') }}" class="navbar-item"><div class="navbar-item-text">User name</div></a>

            <a href="{{route('admin.orders.index')}}" class="navbar-item @if($menu == 'orders') navbar-item-active @endif"><div class="navbar-item-text">@lang('admin.Orders')</div></a>
            <a href="{{route('admin.users.index') . '?signups' }}" class="navbar-item @if($menu == 'customers') navbar-item-active @endif"><div class="navbar-item-text">@lang('admin.SignUPs')</div></a>
            <a href="{{route('admin.products.index')}}" class="navbar-item @if($menu == 'products') navbar-item-active @endif"><div class="navbar-item-text">@lang('admin.Products')</div></a>
            <a href="{{route('admin.pages.index')}}" class="navbar-item @if($menu == 'pages') navbar-item-active @endif"><div class="navbar-item-text">@lang('admin.Pages')</div></a>
            <a href="{{route('admin.attributes.index')}}" class="navbar-item @if($menu == 'attributes' || $menu == 'attribute_values') navbar-item-active @endif"><div class="navbar-item-text">@lang('admin.Attributes')</div></a>
            <a href="{{route('admin.categories.index')}}" class="navbar-item @if($menu == 'categories') navbar-item-active @endif"><div class="navbar-item-text">@lang('admin.Categories')</div></a>
            <div class="btn-group navbar-item @if(in_array($menu, ['settings', 'users', 'permissions', 'roles'])) navbar-item-active @endif">
                <a href="{{route('admin.settings.index')}}"  class="navbar-item @if($menu == 'settings') navbar-item-active @endif" style="width: unset;border-bottom: none;">
                    <div class="navbar-item-text">@lang('admin.Settings')</div>
                </a>
                <button onclick="toggleOtherSettings();" type="button" style="box-shadow: none; max-width: 50px; color:#777777" class="btn dropdown-toggle dropdown-toggle-split" ></button>
            </div>
            <div id="otherSettings" class="other-settings hidden-settings" style="border-bottom:1px solid black">
                <a class="navbar-item @if($menu == 'users') navbar-item-active @endif" href="{{route('admin.users.index')}}">@lang('admin.Users')</a>
                <a class="navbar-item @if($menu == 'permissions') navbar-item-active @endif" href="{{route('admin.permissions.index')}}">@lang('admin.Permissions')</a>
                <a class="navbar-item @if($menu == 'roles') navbar-item-active @endif" href="{{route('admin.roles.index')}}">@lang('admin.Roles')</a>
            </div>
            <a class="navbar-item" href="{{ route('logout') }}"
               onclick="event.preventDefault();
            document.getElementById('logout-form-mobile').submit();">
                <div class="navbar-item-text">{{ __('Logout') }}</div>
            </a>
            <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
    <nav class="navbar" style="background-color: #eeeff1">
        <div class="container-fluid">
            <button style="box-shadow: none" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                <i style="color:#777777 " class="fas fa-bars"></i>
            </button>

        </div>
    </nav>
</header>

