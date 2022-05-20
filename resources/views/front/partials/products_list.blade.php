@foreach($products as $product)
    <a href="{{route('product', ['product' => $product, 'slug' => $product->slug])}}" style="text-decoration: none; color:black">
        <div class="single-product">
            <img class="product-image"  src="{{ Storage::url($product->getImageDimensionPath('featured', 'product_image')) }}" >
            <div class="product-text">
                <div class="product-name">{{$product->name}}</div>
                <div class="product-price">${{$product->getPrice()}}</div>
            </div>
        </div>
    </a>
@endforeach
