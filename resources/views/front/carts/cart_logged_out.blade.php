@extends('front.layout')
@section('custom_css')
    <style>
        body{
            min-height: 100vh;
        }
        .quantityInput{
            background-color: white;
            color: black;
        }
        .noItems{
            text-align: center;
            font-family: Mulish-Light, fantasy;
        }
    </style>
@endsection
@section('content')
    <nav class="breadcrumb-wrapper" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('front.Return to store')</a></li>
            <li class="breadcrumb-item active" aria-current="page">@lang('front.Basket')</li>
        </ol>
    </nav>
    <div class="row cart-container">
        <div class="col-lg-10 cart-header">
            <div class="col-lg-12 cart-count">
               0 @lang('front.item(s) in your basket')
            </div>
        </div>
        <div class="col-lg-7 col-12 cart-items-container">

        </div>
        <div class="col-lg-3 col-12" id="paypalContainer">
            <div class="cart-payment-container">
                <div class="cart-payment-info">
                    <div class="cart-payment-info-header">@lang('front.Order summary')</div>
                    <div class="cart-payment-info-item">
                        <div>@lang('front.Subtotal')</div>
                        <div id="subtotal"></div>
                    </div>
                    <div class="cart-payment-info-item">
                        <div>@lang('front.Shipping')</div>
                        <div id="shipping_cost">${{$settings->shipping}}</div>
                    </div>
                    <small style="font-size: small" class="cart-payment-info-item">
                        @lang('All orders are shipped with tracking via airmail')
                    </small>
                    <hr style="margin: 0 0 0 5%;width: 90%;"/>
                    <div class="cart-payment-info-item">
                        <div style="font-weight: bold">@lang('front.Total')</div>
                        <div style="font-weight: bold" id="total"></div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary cart-payment-button" onclick="location.href = '{{ route('login', ['postCart']) }}'">
                    <i class="fab fa-paypal"></i> @lang('front.REGISTER/LOGIN AND PAY WITH PAYPAL')
                </button>
            </div>
        </div>
    </div>

@endsection
@section('custom_scripts')
    <script src="//cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        const shipping = {{$settings->shipping}};
        const cartItemsContainer = document.querySelector('.cart-items-container');
        const paypalContainer = document.querySelector('#paypalContainer');
        const cartCount = document.querySelector('.cart-count');
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
        (function() {
            axios.post('{{ route('cart.items.render') }}', {
                data: {
                    products: localStorage['products'] ?? JSON.stringify([])
                }
            }).then(({data}) => {
                if(data.html.length === 0) cartItemsContainer.innerHTML = '<h1 class="noItems">@lang('front.There are no products in your basket')</h1>';
                else{
                    cartItemsContainer.innerHTML = data.html;
                    paypalContainer.style.display = 'block';
                }
            }, () => fireToast('error', 'ERROR')).then(() => {
                addQuantityButtonEventListeners();
                document.querySelectorAll('.quantityInput').forEach((input) => {
                    input.addEventListener('change', recalculatePrice);
                })

                recalculatePrice();
                countProducts();
            });
        })();
        const addQuantityButtonEventListeners = () => {
            document.querySelectorAll('.changeQuantity').forEach((button) => {
                const type = button.dataset.type;
                const changeBy = type === 'increase' ? 1 : (-1);
                const id = parseInt(button.dataset.productId);
                const input = button.parentElement.querySelector('input');
                const cartItem = document.querySelector(`.cart-item[data-product-id='${id}']`);
                const maxQuantity = parseInt(cartItem.dataset.maxQuantity);

                button.addEventListener('click', () => {
                    let products = JSON.parse(localStorage['products'] ?? null);
                    products = products ?? [];

                    const index = products.findIndex((item) => item.productID === id);
                    products[index].quantity += changeBy;

                    if(products[index].quantity < 1){
                        fireToast('error', "@lang('front.Quantity can not be less than 1')");
                        return;
                    }
                    else if(products[index].quantity > maxQuantity){
                        fireToast('error', "@lang('front.There is not enough products in stock!')");
                        return;
                    }
                    localStorage['products'] = JSON.stringify(products);

                    input.value = (parseInt(input.value) + changeBy).toString();
                    cartItem.querySelector('.cart-item-price').dataset.quantity = input.value;
                    input.dispatchEvent(new Event('change'));
                })
            });
        }

        const recalculatePrice = () => {
            let subtotal = 0;
            document.querySelectorAll('.cart-item-price').forEach((item) => subtotal += parseInt(item.dataset.price) * parseInt(item.dataset.quantity)/100);
            document.querySelector('#total').textContent = `$${(subtotal+shipping).toLocaleString(undefined, {minimumFractionDigits: 2})}`;
            document.querySelector('#subtotal').textContent = `$${subtotal.toLocaleString(undefined, {minimumFractionDigits: 2})}`;
        }

        const removeItem = (id) => {
            let products = JSON.parse(localStorage['products'] ?? null);
            products = products ?? [];

            products = products.filter(product => product.productID !== id);
            localStorage['products'] = JSON.stringify(products);

            document.querySelector(`.cart-item[data-product-id='${id}']`).remove();
            countProducts();
            recalculatePrice();
        }
        const countProducts = () => {
            const products = document.querySelectorAll('.cart-item');
            if(products.length === 0){
                cartItemsContainer.innerHTML = '<h1 class="noItems">@lang('front.There are no products in your cart')</h1>';
                paypalContainer.style.display = 'none';
            }

            cartCount.textContent = `${products.length} @lang('front.item(s) in your basket')`;
        }
    </script>
@endsection
