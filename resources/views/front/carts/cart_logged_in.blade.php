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
    @if(isset($_GET['postAuth']))
        <div class="alert alert-success alert-dismissible fade show" style="margin-top:20px; justify-self: center;align-self: center;" role="alert">
            <strong>@lang('admin.Success!')</strong> @lang('front.Thank you for signin up. We sent you a confirmation email from Genesis Bricks.') <br>
            @lang('front.Please click on the confrimation link on the email we have just send you, so you can finish your order, receive a transaction confirmation and shipment notification.')
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <nav class="breadcrumb-wrapper" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('front.Return to store')</a></li>
            <li class="breadcrumb-item active" aria-current="page">@lang('front.Basket')</li>
        </ol>
    </nav>
    <div class="row cart-container">
        <div class="col-lg-10 cart-header">
            @if(Session::has('quantityErrors'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach(Session::get('quantityErrors') as $quantity_error)
                        <div>{{ $quantity_error }}</div>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="col-lg-12 cart-count">
                {{ count($order?->order_items ?? []) }} @lang('front.item(s) in your basket')
            </div>
        </div>
        <div class="col-lg-7 col-12 cart-items-container">
            @if($order)
                <form method="post" action="{{ route('payments.pay') }}" id="paymentForm">
                    @csrf
                    @foreach($order->order_items as $order_item)
                        <div class="cart-item" data-item-id="{{ $order_item->id }}">
                            <img src="{{ Storage::url($order_item->product->getImageDimensionPath('featured', 'cart_item_image')) }}" class="cart-item-image">
                            <div class="cart-item-info">
                                <div class="cart-item-name"><a href="{{route('product', ['product' => $order_item->product, 'slug' => $order_item->product->slug])}}">{{ $order_item->product->name }}</a></div>
                                <div class="cart-item-input-group">
                                    <i class="fa fa-minus changeQuantity" data-type="decrease" data-item-id="{{ $order_item->id }}"></i>
                                    <input step="1" min="1" value="{{ $order_item->quantity }}" class="quantityInput" disabled>
                                    <i class="fa fa-plus changeQuantity" data-type="increase" data-item-id="{{ $order_item->id }}"></i>
                                </div>
                                <div>
                                    <div class="cart-item-price"
                                         data-price="{{ $order_item->product->price }}"
                                         data-quantity="{{ $order_item->quantity }}">
                                        ${{ $order_item->product->getPrice() }}
                                    </div>
                                </div>
                            </div>
                            <div class="cart-button-container">
                                <button type="button" class="btn btn-danger cart-button" onclick="removeItem({{ $order_item->id }})"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    @endforeach
                    <textarea class="cart-textarea" name="note" id="note" placeholder="@lang('front.Add note to Genesis Bricks (optional)')"></textarea>
                </form>
            @else
                <h1 class="noItems">@lang('front.There are no products in your basket')</h1>
            @endif
        </div>
        @if(count($order?->order_items ?? []) > 0)
            <div class="col-lg-3 col-12" id="paypalContainer">
                <div class="cart-payment-container">
                    <div class="cart-payment-info">
                        <div class="cart-payment-info-header">@lang('front.Order summary')</div>
                        <div class="cart-payment-info-item">
                            <div>@lang('front.Subtotal')</div>
                            <div id="subtotal">${{ $subtotal }}</div>
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
                            <div style="font-weight: bold" id="total">${{ $total }}</div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary cart-payment-button" onclick="submitPayment()"><i class="fab fa-paypal"></i> @lang('front.PAYPAL')</button>
                </div>
            </div>
        @endif
    </div>
@endsection
@section('custom_scripts')
    <script src="//cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        const shipping = {{$settings->shipping}};
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
        const recalculatePrice = () => {
            let subtotal = 0;
            document.querySelectorAll('.cart-item-price').forEach((item) => subtotal += parseInt(item.dataset.price) * parseInt(item.dataset.quantity)/100);
            document.querySelector('#total').textContent = `$${(subtotal+shipping).toLocaleString(undefined, {minimumFractionDigits: 2})}`;
            document.querySelector('#subtotal').textContent = `$${(subtotal).toLocaleString(undefined, {minimumFractionDigits: 2})}`;
        }
        document.querySelectorAll('.changeQuantity').forEach((button) => {
            const type = button.dataset.type;
            button.addEventListener('click', () => {
                const id = button.dataset.itemId;
                axios.post('{{ route('cart.items.change_quantity') }}', {
                    headers: {
                        'x-csrf-token': document.querySelector('meta[name="csrf-token"]').getAttributeNode('content').value,
                    },
                    data: {
                        'id': id,
                        'type': type
                    }
                }).then(() => {
                    const changeBy = type === "increase" ? 1 : -1;
                    const input = button.parentElement.querySelector('input');
                    input.value = (parseInt(input.value) + changeBy).toString();
                    document.querySelector(`.cart-item[data-item-id='${id}']`).querySelector('.cart-item-price').dataset.quantity = input.value;
                    input.dispatchEvent(new Event('change'));
                }, (error) => error.response.status === 406 ? fireToast('error', error.response.data.message) : fireToast('error', 'ERROR'));
            })
        })
        document.querySelectorAll('.quantityInput').forEach((input) => {
            input.addEventListener('change', recalculatePrice);
        })
        const removeItem = (id) => {
            axios.post('{{ route('cart.items.remove') }}', {
                headers: {
                    'x-csrf-token': document.querySelector('meta[name="csrf-token"]').getAttributeNode('content').value,
                },
                data: {
                    'id': id
                }
            }).then(() => {
                document.querySelector(`.cart-item[data-item-id='${id}']`).remove();
                countProducts();
                recalculatePrice();
            })
        }
        const countProducts = () => {
            const products = document.querySelectorAll('.cart-item');
            if(products.length === 0){
                document.querySelector('.cart-items-container').innerHTML = '<h1 class="noItems">@lang('front.There are no products in your cart')</h1>';
                document.querySelector('#paypalContainer').style.display = 'none';
            }

            document.querySelector('.cart-count').textContent = `${products.length} @lang('front.item(s) in your basket')`;
        }
        const submitPayment = () => document.querySelector('#paymentForm').submit();
        @if(isset($_GET['postAuth'])) localStorage.removeItem('products'); @endif
    </script>
@endsection
