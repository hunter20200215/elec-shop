@extends('front.layout')
@section('custom_css')
@endsection
@section('content')
    <div class="row cart-container">
        <nav class="breadcrumb-wrapper" style="width: 100%; padding-left: 7%; margin-left: 0;" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('front.Return to store')</a></li>
            </ol>
        </nav>
        <h1 style="width:50%" class="noItems">{{$text}}</h1>
    </div>
@endsection
@section('custom_scripts')
@endsection
