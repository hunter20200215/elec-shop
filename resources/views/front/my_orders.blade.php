@extends('front.layout')
@section('custom_css')
    <style>
        .accordion-button div{
            margin-left: 5%
        }
        @media(max-width: 767px){
            .accordion-button{
                overflow: scroll;
            }
            .accordion-body{
                overflow: scroll;
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
                    <a class="my-account-option-text active-link" href="{{route('my_orders')}}">
                        @lang('front.My orders')
                    </a>
                </div>
                @if(Auth::user()->unsubscribed == 0)
                    <div class="my-account-option">
                        <a class="my-account-option-text" href="{{route('unsubscribe')}}">
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
            <div class="col-12 col-md-6 col-lg-5">
                <div class="accordion" id="ordersAccordion">
                    @foreach($orders as $order)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading_{{$order->id}}">
                                <button class="accordion-button {{ $loop->iteration === 1 ? '' : 'collapsed'}}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{$order->id}}" aria-expanded="false" aria-controls="collapse_{{$order->id}}">
                                    <div style="margin:0">
                                        @lang('front.Order #'){{$order->getIDWithYear()}}
                                    </div>
                                    <div>
                                        @lang('front.Order date'): {{\Carbon\Carbon::parse($order->order_date)->format('d.m.Y')}}
                                    </div>
                                    <div>
                                        @lang('front.Total'): {{$order->getPriceWithShipping()}}
                                    </div>
                                    <div>
                                        @lang('front.Status'): {{$order->getStatusText()}}
                                    </div>
                                </button>
                            </h2>
                            <div id="collapse_{{$order->id}}" class="accordion-collapse collapse {{ $loop->iteration === 1 ? 'show' : ''}}" aria-labelledby="heading_{{$order->id}}">
                                <div class="accordion-body">
                                    <table class="table" id="orderItemsTable">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">@lang('front.Product')</th>
                                            <th scope="col">@lang('front.Quantity')</th>
                                            <th scope="col">@lang('front.Price')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($order->order_items as $order_item)
                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{$order_item->product->name}}</td>
                                                <td>{{$order_item->quantity}}</td>
                                                <td>{{$order_item->getPrice()}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom_scripts')
@endsection

