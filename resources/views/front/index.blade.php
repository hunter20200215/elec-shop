@extends('front.layout')
@section('custom_css')
    <link href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/front/rSlider.min.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"/>
    <style>
        ins:before{
            content: '$';
        }
        select{
            border-radius: 30px !important;
            border:1px solid #0000001A!important;
            font-family: DroidSerif, sans-serif;
        }
        select:focus{
            box-shadow: none!important;
        }
    </style>
@endsection
@section('content')
    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissible fade show col-lg-8 offset-lg-2 col-12" style="margin-top:20px;" role="alert">
            <strong>@lang('admin.Success!')</strong> {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="categories">
        @foreach($featured_categories as $featured_category)
            <a href="{{ route('index', ['categories' => $featured_category->id ]) }}">
                <div class="category-ellipsis">
                    <img class="category-icon-image" src="{{Storage::url($featured_category->getImageDimensionPath('featured', 'category_icon_image'))}}">
                    <div class="category-name">{{$featured_category->name}}</div>
                </div>
            </a>
        @endforeach
    </div>
    <div class="products-container row col-12" style="margin:0">
        <div class="product-filters col-lg-2 col-md-3 col-12">
            <div id="toggleAllFilters" onclick="toggleFilter(this)" data-controls="allFilters" style="display: flex; justify-content: space-between; flex-direction: row; align-items: center">
                <h2 id="filtersHeader" style="font-family: DroidSerif, sans-serif">@lang('front.Filters')</h2>
                <div><i class="fa fa-minus"></i></div>
            </div>
            <div id="allFilters" style="display: flex; flex-direction: column">
                <div class="search-products-div">
                    <input class="search-products-input" placeholder="@lang('front.Search')" name="search_products_by_name" value="{{ $_GET['searchTerm'] ?? '' }}">
                </div>
                <div class="filters-header">
                    <h3> @lang('front.Price') </h3>
                </div>
                <div id="priceFilters">
                    <div class="price-slider">
                        <input type="text" id="priceSlider"/>
                    </div>
                </div>
                <div class="filters-header" onclick="toggleFilter(this)" data-controls="categoriesFilters">
                    <h3> @lang('front.Categories') </h3>
                    <div><i class="fas fa-minus"></i></div>
                </div>
                <div id="categoriesFilters" class="filter-items-container" style="margin-bottom:10px;">
                    @foreach($categories as $category)
                        <div class="pretty p-default" style="width: 100%">
                            <input name="category_id[]" class="categories-checkbox" value="{{$category->id}}"
                                   type="checkbox"
                                   {{ in_array($category->id, $selected_categories) ? 'checked' : '' }}
                            />
                            <div class="state p-primary" style="display: flex; justify-content: space-between">
                                <label style="justify-self: flex-start">{{$category->name}}</label>
                                <label style="justify-self: flex-end">{{$category->products_count}}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
                @foreach($attributes as $attribute)
                    <div class="filters-header" onclick="toggleFilter(this)" data-controls="attributeFilters_{{$attribute->id}}">
                        <h3>{{$attribute->name}}</h3>
                        <div><i class="fas fa-minus"></i></div>
                    </div>

                    <div id="attributeFilters_{{$attribute->id}}" class="filter-items-container" style="@if($attribute->getFirstValueType())display: flex; flex-direction: row; justify-content: flex-start; @endif margin-bottom:10px">
                        @if($attribute->search_type == 'list')
                            <select class="form-control select-picker" data-trigger name="attribute_value_id[]">
                                <option value="0" selected>@lang("admin.All")</option>
                                @foreach($attribute->attribute_values as $attribute_value)
                                    <option
                                        value="{{$attribute_value->id}}"
                                        {{ in_array($attribute_value->id, $selected_attribute_values) ? 'selected' : '' }}
                                    >
                                        {{$attribute_value->value}}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            @foreach($attribute->attribute_values as $attribute_value)
                                @if($attribute_value->color)
                                    <div class="color-filter-item-outer {{ in_array($attribute_value->id, $selected_attribute_values) ? 'selected' : '' }}">
                                        <input name="attribute_value_id[]" value="{{$attribute_value->id}}" type="checkbox"  style="display: none"/>
                                        <div class="color-filter-item-inner" style="background-color: {{$attribute_value->color}}"></div>
                                    </div>
                                @else
                                    <div class="pretty p-default" style="width: 100%">
                                        <input class="attribute-value-input" name="attribute_value_id[]" value="{{$attribute_value->id}}"
                                               type="checkbox" {{ in_array($attribute_value->id, $selected_attribute_values) ? 'checked' : '' }}/>
                                        <div class="state p-primary" style="display: flex; justify-content: space-between">
                                            <label style="justify-self: flex-start">{{$attribute_value->value}}</label>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                @endforeach
                <button class="search-button" type="button" onclick="submitSearch()" id="searchButton" style="display: none">Search</button>
            </div>
        </div>
        <div class="products col-lg-6 col-md-7 col-12">
            <div class="products-header">
                <a href="{{ route('index') }}"><h3 class="products-header-tab" style="border-bottom:{{$index_type == '/' ? '1px solid black' : ''}}">@lang('front.Recently added')</h3></a>
                <a href="{{ route('trending') }}" style="margin-left: 30px"><h3 class="products-header-tab" style="border-bottom:{{$index_type == '/trending' ? '1px solid black' : ''}}">@lang('front.Trending')</h3></a>
            </div>
            <div class="products-subheader">
                <div style="">
                    <select class="form-select form-select-sm sortSelect" aria-label="form-select-sm">
                        <option selected value="" disabled>@lang('front.Select an option')</option>
                        <option value="name_asc" {{ $selected_sort_option == 'name_asc' ? 'selected' : ''}}>
                            @lang('front.Name') (@lang('front.A-Z'))
                        </option>
                        <option value="name_desc" {{ $selected_sort_option == 'name_desc' ? 'selected' : ''}}>
                            @lang('front.Name') (@lang('front.Z-A'))
                        </option>
                        <option value="price_desc" {{ $selected_sort_option == 'price_desc' ? 'selected' : ''}}>
                            @lang('front.Price') (@lang('front.descending'))
                        </option>
                        <option value="price_asc" {{ $selected_sort_option == 'price_asc' ? 'selected' : ''}}>
                            @lang('front.Price') (@lang('front.ascending'))
                        </option>
                    </select>
                </div>
            </div>
            <div class="products-list">
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
            </div>
            @if($products->nextPageUrl())
                <button class="load-more-button" data-href="{{ $products->nextPageUrl() }}" onclick="loadMore(this)">@lang('front.Load more products')</button>
            @endif
        </div>
    </div>
@endsection
@section('custom_scripts')
    <script src="{{asset('js/front/rSlider.min.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        // initialization
        const selects = document.querySelectorAll('.select-picker');
        const min = {{ get_price_display_value($min) }}, max = {{ get_price_display_value($max) }};
        const searchButton = document.querySelector('#searchButton');
        const categoryIDs = {!! json_encode($selected_categories)  !!},
            attributeValues = {!! json_encode($selected_attribute_values)  !!},
            priceRange = {'min': {{ $_GET['min'] ?? get_price_display_value($min) }}, 'max': {{ $_GET['max'] ?? get_price_display_value($max) }}, 'changed': 0},
            sortInfo = {'sortBy': '{{ $_GET['sortBy'] ?? '' }}', 'sortDirection': '{{ $_GET['sortDirection'] ?? '' }}' };
        let searchTerm = '{{ $_GET['searchTerm'] ?? '' }}', changeHappened = 1;
        const priceSlider = new rSlider({
            target: '#priceSlider',
            width: document.querySelector('.product-filters').offsetWidth - 40,
            values: {min, max},
            step: (max-min)/5,
            set: [priceRange.min, priceRange.max],
            range: true,
            tooltip: false,
            scale: true,
            labels: true,
            onChange: function (value) {
                let values = value.split(',');
                if(values[1] !== 'undefined'){
                    if(priceRange.min !== parseInt(values[0]) || priceRange.max !== parseInt(values[1])){
                        priceRange.min = parseInt(values[0]);
                        priceRange.max = parseInt(values[1]);
                        priceRange.changed = 1;
                        showSearchButton();
                    }
                }
                else priceRange.max = 0;
            }
        });
        [...selects].map((element) => {
            new Choices(element, {
                placeholder: true,
                itemSelectText: '@lang('admin.Click to select a value')',
            })
        })

        // Event listeners
        selects.forEach((select) => {
            attributeValues.indexOf(select.value) > -1 ? attributeValues.splice(attributeValues.indexOf(select.value), 1) : null;
            select.addEventListener('change', () => {
                changeHappened = 1
                shouldSearchBeVisible();
            })
        })
        document.querySelector('.search-products-input').addEventListener('keyup', function (e){
            if(e.keyCode === 13){
                submitSearch();
            }
            changeHappened = 1;
            searchTerm = this.value;
            shouldSearchBeVisible();
        })
        document.querySelectorAll('.categories-checkbox').forEach((input) => {
            input.addEventListener('change', () => {
                changeHappened = 1;
                input.checked ? categoryIDs.push(input.value) : categoryIDs.splice(categoryIDs.indexOf(input.value), 1);
                shouldSearchBeVisible();
            });
        });
        document.querySelectorAll('.color-filter-item-outer').forEach((colorBox) => {
            colorBox.addEventListener('click', () => {
                changeHappened = 1;
                let input = colorBox.querySelector('input');
                if(colorBox.classList.contains('selected')){
                    colorBox.classList.remove('selected');
                    attributeValues.splice(attributeValues.indexOf(input.value), 1);
                }
                else{
                    colorBox.classList.add('selected');
                    attributeValues.push(input.value);
                }
                shouldSearchBeVisible();
            })
        });
        document.querySelectorAll('.attribute-value-input').forEach((input) => {
            input.addEventListener('click', () => {
                changeHappened = 1;
                if(input.type === 'checkbox'){
                    input.checked ? attributeValues.push(input.value) : attributeValues.splice(attributeValues.indexOf(input.value), 1);
                }
                shouldSearchBeVisible();
            })
        });
        document.querySelector('.sortSelect').addEventListener('change', function(){
            changeHappened = 1;
            const [sortBy, sortDirection] = this.value.split('_');
            sortInfo.sortBy = sortBy;
            sortInfo.sortDirection = sortDirection;
            submitSearch();
        });

        // Methods
        const shouldSearchBeVisible = () => {
            if(changeHappened === 0) hideSearchButton();
            else showSearchButton();
        }
        const hideSearchButton = () => searchButton.style.display = 'none';
        const showSearchButton = () => searchButton.style.display = 'block';
        const submitSearch = () => {
            selects.forEach((select) => select.value > 0 ? attributeValues.push(select.value) : null);
            let filters = '';
            if(priceRange.changed === 1) filters += `&min=${priceRange.min}&max=${priceRange.max}`;
            if(categoryIDs.length > 0) filters += `&categories=${categoryIDs.join(',')}`;
            if(searchTerm.length > 0) filters += `&searchTerm=${searchTerm}`;
            if(attributeValues.length > 0) filters += `&attributeValues=${attributeValues.join(',')}`;
            if(sortInfo.sortBy !== '' && sortInfo.sortDirection !== '') filters += `&sortBy=${sortInfo.sortBy}&sortDirection=${sortInfo.sortDirection}`

            filters = filters.substring(1);
            location.href = `?${filters}`;
        }
        const loadMore = (_this) => {
            const uri = _this.dataset.href;
            axios.get(uri, {
                params: {api: ''}
            })
            .then(({data}) => {
                document.querySelector('.products-list').insertAdjacentHTML('beforeend', data.html);
                if(data.href) _this.dataset.href = data.href;
                else _this.style.display = 'none';
            }, () => console.log('ERROR'));
        }
        const toggleFilter = (_this) => {
            let parentElement = _this
            let icon = parentElement.querySelector('div').firstChild;
            let childElement = document.querySelector(`#${parentElement.dataset.controls}`)

            if(icon.classList.contains('fa-minus')) {
                icon.classList.remove('fa-minus')
                icon.classList.add('fa-plus')
            }
            else{
                icon.classList.remove('fa-plus')
                icon.classList.add('fa-minus')
            }
            if(childElement.clientHeight > 0) {
                childElement.style.overflow = 'hidden';
                childElement.style.height = 0;
                childElement.style.padding = 0;
            }
            else {
                if(parentElement.id !== 'toggleAllFilters'){
                    childElement.style.overflow = 'hidden';
                    childElement.style.height = 'auto';
                    childElement.style.padding = '10px 0';
                }
                else {
                    childElement.style.height = 'auto';
                    childElement.style.overflow = 'visible'
                }
            }
        }
    </script>
@endsection

