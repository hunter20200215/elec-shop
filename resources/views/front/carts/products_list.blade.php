@foreach($products as $product)
    <div class="cart-item" data-product-id="{{ $product->id }}" data-max-quantity="{{ $product->quantity }}">
        <img src="{{ Storage::url($product->getImageDimensionPath('featured', 'cart_item_image')) }}" class="cart-item-image">
        <div class="cart-item-info">
            <div class="cart-item-name"><a href="{{route('product', ['product' => $product, 'slug' => $product->slug])}}">{{ $product->name }}</a></div>
            <div class="cart-item-input-group">
                <i class="fa fa-minus changeQuantity" data-type="decrease" data-product-id="{{ $product->id }}"></i>
                <input step="1" min="1" value="{{ $product->cart_quantity }}" class="quantityInput" disabled>
                <i class="fa fa-plus changeQuantity" data-type="increase" data-product-id="{{ $product->id }}"></i>
            </div>
            <div>
                <div class="cart-item-price"
                     data-price="{{ $product->price }}"
                     data-quantity="{{ $product->cart_quantity }}">
                    ${{ $product->getPrice() }}
                </div>
            </div>
        </div>
        <div class="cart-button-container">
            <button class="btn btn-danger cart-button" onclick="removeItem({{ $product->id }})"><i class="fa fa-trash"></i></button>
        </div>
    </div>
@endforeach
