@extends('front.layout')
@section('custom_css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
    <link rel="stylesheet" href="{{ asset('css/front/product.css') }}">
@endsection
@section('content')
    <nav class="breadcrumb-wrapper" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('front.Home')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('index', ['categories' => $product->category->id ]) }}">{{ $product->category->name}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>
    <div class="product-container">
        <div class="product-images">
            <div id="secondary-slider" class="splide">
                <div class="splide__track">
                    <ul class="splide__list" >
                        @foreach($product->model_images as $model_image)
                            <li class="splide__slide">
                                <img class="product-image splide__slide" src="{{Storage::url($model_image->image->getDimensionPath('product_slider_image'))}}">
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="product-info">
            <h3 class="product-details-header-mobile">{{$product->name}}</h3>
            <div id="primary-slider" class="splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach($product->model_images as $model_image)
                            <li class="splide__slide">
                                <img class="product-main-image splide__slide" src="{{Storage::url($model_image->image->getDimensionPath('product_main_image'))}}">
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="product-details">
                <h3 class="product-details-header">{{$product->name}}</h3>
                <div class="product-pricing">
                    <div class="product-price">${{$product->getPrice()}} <span class="span-price">@lang('front.each')</span></div>

                    <div class="product-change-quantity-input-group">
                        <i class="fa fa-minus" id="decreaseQuantity"></i>
                        <input step="1" min="1" value="1" disabled id="quantityInput">
                        <i class="fa fa-plus" id="increaseQuantity"></i>
                    </div>
                    <button class="btn btn-dark add-to-cart-button" id="addToCart">@lang('front.ADD TO CART')</button>
                </div>
                <div class="product-stock-container">
                    <div class="product-quantity"><i class="fas fa-store"{{$product->quantity > 0 ? 'style=color:#32880C' : 'style=color:red'}}></i> {{$product->quantity > 0 ? Lang::get('front.In stock') : Lang::get('front.Sold out')}}</div>
                    <div class="available-stock"style="{{$product->quantity > 0 ? '' : 'style=rgba(255, 0, 0, 0.14)'}}">@lang('front.Available'): {{$product->quantity}}</div>
                </div>
                <div class="product-features">
                    <div class="features-header"><i class="fas fa-star"></i> @lang('front.Highlights')</div>
                    <div class="product-attributes">
                        @foreach($attribute_values as $attribute_value)
                            <div class="product-attribute">
                                <i class="fas fa-fingerprint" style="color: #4B505B"></i>
                                <div class="attribute-text" >
                                    {{$attribute_value->attribute->name}}: {{$attribute_value->value}}
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="product-features">
                    <div class="features-header"><i class="fas fa-star"></i> @lang('front.Description')</div>
                    <div>
                        {!! $product->description  !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="related-products" style="{{count($related_products) > 0 ? '' : 'height:0; border:none; overflow:hidden'}}">
            <h3 class="related-products-header">@lang('front.Related products')</h3>
            <span class="related-products-subtext">{{$product->category?->name}}</span>
            <div id="related-slider" class="splide">
                <div class="splide__track">
                    <ul class="splide__list" >
                        @foreach($related_products as $related_product)
                            <li class="splide__slide">
                                <a href="{{route('product', ['product' => $related_product, 'slug' => $related_product->slug])}}" style="text-decoration: none; color:black">
                                    <div class="related-product">
                                        <img class="related-product-image splide__slide" src="{{Storage::url($related_product->getImageDimensionPath('featured', 'related_product_image'))}}">
                                        <div class="related-product-text">{{$related_product->name}}</div>
                                        <div class="related-product-price">{{$related_product->getPrice()}}</div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <a href="{{route('index')}}"><button class="browse-all-button">@lang('front.BROWSE ALL ITEMS')</button></a>
    </div>
@endsection
@section('custom_scripts')
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        const fireToast = (icon, text) => {
            Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
            }).fire({
                icon: icon,
                title: text
            });
        };
        document.querySelector('#increaseQuantity').addEventListener('click', function(){
            const input = document.querySelector('#quantityInput');
            input.value = (parseInt(input.value) + 1).toString();
        })
        document.querySelector('#decreaseQuantity').addEventListener('click', function(){
            const input = document.querySelector('#quantityInput');
            input.value = (parseInt(input.value) - 1).toString();
            if(input.value < 1) input.value = '1';
        })
        document.querySelector('#addToCart').addEventListener('click', () => {
            const quantity = document.querySelector('#quantityInput').value;
            if(quantity > {{ $product->quantity }}){
                fireToast('error', '@lang("front.There is not enough products in stock!")');
                return;
            }
            @if(Auth::check())
                axios.post('{{ route('cart.items.add') }}', {
                    headers: {
                        'x-csrf-token': document.querySelector('meta[name="csrf-token"]').getAttributeNode('content').value,
                    },
                    data: {
                        'id': {{ $product->id }},
                        'quantity': quantity
                    }
                }).then(() => {
                    document.querySelector('#quantityInput').value = 1;
                    fireToast('success', '@lang("front.Items added to cart.")');
                }, () => fireToast('error', '@lang("front.There was an error with adding items to cart.")'))
            @else
                let products = JSON.parse(localStorage['products'] ?? null);
                products = products ?? [];

                const index = products.findIndex((item) => item.productID === {{ $product->id }});

                if(index === -1){
                    const orderItem = {'productID': {{ $product->id}}, 'quantity': parseInt(quantity)};
                    products.push(orderItem);
                }
                else products[index].quantity += parseInt(quantity);

                localStorage['products'] = JSON.stringify(products);
                fireToast('success', '@lang("front.Items added to cart.")');
            @endif
        })
        // Create and mount the thumbnails slider.
        document.addEventListener( 'DOMContentLoaded', function () {
        if(screen.width >= 768){
            let secondarySliderWidth = document.querySelectorAll('.product-image').length * 135 + 50
            let relatedSliderWidth = document.querySelectorAll('.related-product-image').length * 207 + 50
            if(secondarySliderWidth > 600) secondarySliderWidth = 600;
            if(relatedSliderWidth > 1085) relatedSliderWidth = 1085;
            let secondarySlider = new Splide( '#secondary-slider', {
                fixedWidth  : '135px',
                autoHeight: true,
                autoWidth:true,
                height      : secondarySliderWidth+'px',/*height      : '600px',*/
                gap         : 10,
                direction: 'ttb',
                isNavigation: true,
                pagination:false,
                perPage: 4,
            } ).mount();

            let primarySlider = new Splide( '#primary-slider', {
                type       : 'fade',
                autoHeight: true,
                autoWidth:true,
                pagination : false,
                arrows     : false,
                heightRatio: 1
            } ); // do not call mount() here.
            let relatedSlider = new Splide( '#related-slider', {
                fixedWidth  : '207px',
                type: 'slide',
                width: relatedSliderWidth+'px',
                fixedHeight: '173px',
                height      : 'auto',
                gap         : 10,
                isNavigation: false,
                arrows:true,
                pagination:false,
                perPage: 5,
                clones:0,

            } ).mount();
            primarySlider.sync( secondarySlider ).mount();
        }
        else{
            let primarySlider = new Splide( '#primary-slider', {
                autoWidth:true,
                autoHeight:true,
                focus:'center',
                pagination : true,
                arrows     : false,
                perPage:1,
            } ).mount();

            let relatedSlider = new Splide( '#related-slider', {
                autoWidth:true,
                type: 'slide',
                fixedHeight: '151px',
                height      : 'auto',
                width: '100%',
                gap         : 10,
                focus: 'center',
                arrows:false,
                isNavigation: false,
                pagination:false,
                perPage: 2,
                clones:0,
            } ).mount();

        }
    });
    </script>
@endsection
