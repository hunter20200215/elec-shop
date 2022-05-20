<header class="main-header">
    @if($settings->logo)
        <div style="display: flex">
            <a href="{{ route('index') }}"><img style="height:70px; width:75px" src="{{Storage::url($settings->logo)}}"></a>
            <a href="{{ route('index') }}" style="display: flex"><div class="website-name">{{$settings->name}}</div></a>
        </div>
    @endif
    <nav class="navbar" role="navigation">
        <a href="{{route('contact_us')}}" id="contactUsNavbarItem" class="navbar-item">
            <i style="margin-right: 10px" class="fas fa-phone-alt"></i>
            <div class="navbar-item-text">
                @lang('front.Contact us')
            </div>
        </a>
        <a href="{{route('page', ['page' => 'about-us'])}}" id="aboutUsNavbarItem" class="navbar-item">
            <i style="margin-right: 10px"  class="fas fa-info"></i>
            <div class="navbar-item-text">
                @lang('front.About us')
            </div>
        </a>
        <a href="/cart" class="navbar-item" id="cartNavbarItem">
            <i style="margin-right: 10px" class="fas fa-shopping-cart"></i>
            <div class="navbar-item-text">
                @lang('front.Basket')
            </div>
        </a>
        @if(Auth::check())
            <a href="{{ route('my_account') }}" id="userNavbarItem" class="navbar-item">
                <i style="margin-right: 10px" class="fas fa-user"></i>
                <div class="navbar-item-text">
                    @lang('front.Profile')
                </div>
            </a>
        @else
            <a href="{{ route('login') }}" id="userNavbarItem" class="navbar-item">
                <i style="margin-right: 10px" class="fas fa-user"></i>
                <div class="navbar-item-text">
                    @lang('front.Login')
                </div>
            </a>
        @endif
    </nav>
</header>
