@extends('front.layout')
@section('custom_css')
    <style>
        .my-account-options{
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            padding:25px;
        }
        .my-account-option-text{
            color: #8d8d8d;
        }
        .form-group{
            margin-bottom: 1rem;
        }
        .my-profile-content-container{
            display: flex;
            flex-direction: row;
            justify-content: center;
        }
        .custom-hr{
            width: 0;
            display: none;
        }
        .my-account-option{
            margin-bottom:10px;
        }
        .my-account-option-text{
            font-size: 15pt;
        }
        @media(max-width: 767px){
            .custom-hr{
                width: 100%;
                display: block;
            }
            .my-profile-content-container{
                flex-wrap: wrap;
            }
        }
    </style>
@endsection
@section('content')
    <div class="page-container">
        <div class="col-12 my-profile-content-container" style="">
            <div class="col-12 col-md-4 col-lg-2" style="" class="my-account-options">
                <div class="my-account-option">
                    <a class="my-account-option-text" href="{{route('my_account')}}">
                        @lang('front.My account')
                    </a>
                </div>
                <div class="my-account-option">
                    <a class="my-account-option-text" href="{{route('my_orders')}}">
                        @lang('front.My orders')
                    </a>
                </div>
                @if(Auth::user()->unsubscribed == 0)
                    <div class="my-account-option">
                        <a class="my-account-option-text active-link" href="{{route('unsubscribe')}}">
                            @lang('front.Unsubscribe')
                        </a>
                    </div>
                @endif
                @if(Auth::user()->hasRole('admin'))
                    <div class="my-account-option">
                        <a class="my-account-option-text" href="{{route('admin.dashboard')}}">
                            @lang('front.Administration')
                        </a>
                    </div>
                @endif
                <div class="my-account-option">
                    <a class="my-account-option-text" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
            document.getElementById('logout-form-front').submit();">
                        <div class="navbar-item-text">{{ __('Logout') }}</div>
                    </a>
                    <form id="logout-form-front" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
            <hr class="custom-hr"/>
            <div class="col-12 col-md-6 col-lg-5" style="">
                <form method="POST" style="display: flex;justify-content: center; flex-direction: column; align-items: center" action="{{route('unsubscribe')}}" >
                    @csrf
                    <div class="form-group">
                        <p style="font-family: Mulish-Bold, fantasy">@lang('front.If you are no longer interested in receiving updates from our site please click the button below.')</p>
                    </div>
                    <button type="submit" class="btn btn-primary btn-dark" style="border-radius: 10px; padding:15px; width: 25%">@lang('front.Unsubscribe')</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('custom_scripts')
@endsection

