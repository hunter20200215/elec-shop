@extends('admin.layout')
@section('custom_css')
    <link href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"/>
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="content-header-text">@lang('admin.Products') / @lang('admin.edit')</div>
        </section>
        <section class="content-container">
            @error('category_id')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>@lang('admin.Error!')</strong> @lang("session_messages.You can not publish a product without a category!")
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @enderror
            <form method="POST" class="crud-form">
                @csrf
                <div class="form-group col-md-6" >
                    <label for="name">@lang('admin.Name')</label>
                    <input value="{{old('name', $product->name)}}" type="text" class="form-control @error('name') input-error-danger @enderror" id="name" name="name" placeholder="@lang('admin.Name')">
                    @error('name') <span style="color:red">{{$message}}</span>@enderror
                </div>
                <div class="form-group col-md-6" >
                    <label for="price">@lang('admin.Price')</label>
                    <input value="{{old('price',$product->getPrice())}}" type="number" step="0.01" class="form-control @error('price') input-error-danger @enderror" id="price" name="price" placeholder="@lang('admin.Price')">
                    @error('price') <span style="color:red">{{$message}}</span>@enderror
                </div>
                <div class="form-group col-md-6" >
                    <label for="quantity">@lang('admin.Quantity')</label>
                    <input value="{{old('quantity', $product->quantity) }}" type="number" step="1" class="form-control @error('quantity') input-error-danger @enderror" id="quantity" name="quantity" placeholder="@lang('admin.Quantity')">
                    @error('quantity') <span style="color:red">{{$message}}</span>@enderror
                </div>
                <div class="form-group col-md-6" >
                    <label for="sku">@lang('admin.SKU')</label>
                    <input value="{{old('sku', $product->sku) }}" type="text" class="form-control @error('sku') input-error-danger @enderror" id="sku" name="sku" placeholder="@lang('admin.SKU')">
                    @error('sku') <span style="color:red">{{$message}}</span>@enderror
                </div>
                <div class="form-group col-md-6" >
                    <label for="category_select">@lang('admin.Category')</label>
                    <select class="form-control select-picker" data-trigger name="category_id" id="category_select">
                        <option value="" disabled selected>@lang("admin.Select a category")</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" @if($product->category_id === $category->id) selected @endif>{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6" >
                    <label for="description">@lang('admin.Description')</label>
                    <textarea id="description" name="description">{{ old('description', $product->description) }}</textarea>
                </div>
                <div class="form-group col-md-6" >
                    <label for="published">@lang('admin.Published')</label>
                    <div class="col-md-6" style="margin-top: 5px">
                        <div class="pretty p-default p-round p-thick">
                            <input type="radio" name="published" value="1" {{ $product->published === 1 ? 'checked' : '' }} />
                            <div class="state p-primary-o">
                                <label>@lang('admin.Yes')</label>
                            </div>
                        </div>
                        <div class="pretty p-default p-round p-thick">
                            <input type="radio" name="published" value="0" {{ $product->published === 0 ? 'checked' : '' }} />
                            <div class="state p-primary-o">
                                <label>@lang('admin.No')</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6" >
                    <label for="on_sale">@lang('admin.Trending')</label>
                    <div class="col-md-6" style="margin-top: 5px">
                        <div class="pretty p-default p-round p-thick">
                            <input type="radio" name="trending" value="1" {{ $product->trending === 1 ? 'checked' : '' }} />
                            <div class="state p-primary-o">
                                <label>@lang('admin.Yes')</label>
                            </div>
                        </div>
                        <div class="pretty p-default p-round p-thick">
                            <input type="radio" name="trending" value="0" {{ $product->trending === 0 ? 'checked' : '' }} />
                            <div class="state p-primary-o">
                                <label>@lang('admin.No')</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="attributes">@lang('admin.Attributes')</label>
                    @foreach($attributes as $attribute)
                        <div class="form-group" style="margin-left: 30px;">
                            <label for="{{$attribute->name}}">{{ $attribute->name }}</label>
                            <select class="form-control select-picker" data-trigger name="attribute_values[]">
                                <option value="" disabled selected>@lang("admin.Select an attribute")</option>
                                @foreach($attribute->attribute_values as $attribute_value)
                                    <option value="{{ $attribute_value->id }}"
                                        {{ in_array($attribute_value->id, $product->getProductAttributeValueIDs()) ? 'selected' : '' }}
                                    >{{ $attribute_value->value }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
                <div class="form-group col-md-6" style="margin-bottom: 10px; margin-top: 10px">
                    <label for="featured_image">@lang('admin.Featured image')</label>
                    <button type="button" onclick="openModal('featured', 'm')" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;@lang('admin.Change image')</button>
                    <div class="image-container" id="featured">
                        <img class="img-fluid" data-image-gallery-id="{{ $product->getImage('featured')?->id }}" src="{{ Storage::url($product->getImageDimensionPath('featured', 'm')) }}">
                        @if(is_object($product->getImage('featured')))
                            <button type="button" class="btn btn-danger delete-button" onclick="deleteModelImage({{ $product->getImage('featured')->id }}, false)"><i class="fa fa-trash"></i></button>
                            <a data-fslightbox="lightbox-featured" href="{{ Storage::url($product->getImageDimensionPath('featured', 'l')) }}" class="preview-button">
                                <button type="button" class="btn btn-md btn-info"><i class="fa fa-search"></i></button>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="form-group col-md-6" style="margin-bottom: 10px">
                    <label for="featured_image">@lang('admin.Gallery')</label>
                    <button type="button" onclick="openModal('gallery', 'preview', 'any')" class="btn  btn-sm btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;@lang('admin.Add images')</button>
                    <div class="image-gallery-container" id="gallery">
                        @foreach($product->getImages('gallery') as $model_image)
                            <div class="image-container image-gallery">
                                <img class="img-responsive" data-image-gallery-id="{{ $model_image->id }}" src="{{ Storage::url($model_image->image->getDimensionPath('preview')) }}">
                                <button type="button" class="btn btn-danger delete-button" onclick="deleteModelImage({{$model_image->id}}, true)"><i class="fa fa-trash"></i></button>
                                <a data-fslightbox="lightbox-gallery" href="{{ Storage::url($model_image->image->getDimensionPath('l')) }}" class="preview-button">
                                    <button type="button" class="btn btn-md btn-info"><i class="fa fa-search"></i></button>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary">@lang('admin.Save')</button>
                </div>
            </form>
        </section>
    </div>
    @include('admin.media.gallery_modal')
@endsection
@section('custom_scripts')
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="{{asset('js/admin/ckeditor/ckeditor.js')}}"></script>
    <script>
        CKEDITOR.replace('description', {
            maxHeight: 500,
            minHeight: 150,
            toolbar: [
                {
                    name: 'clipboard',
                    items: ['Undo', 'Redo', 'clipboard']
                },
                {
                    name: 'styles',
                    items: ['Format', 'Font', 'FontSize']
                },
                '/',
                {
                    name: 'colors',
                    items: ['TextColor', 'BGColor']
                },
                {
                    name: 'align',
                    items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                },
                {
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'CopyFormatting']
                },
                {
                    name: 'links',
                    items: ['Link', 'Unlink']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
                },
                {
                    name: 'colors',
                    items: []
                },
                {
                    name: 'tools',
                    items: ['Maximize']
                },
            ]
        });
        const elements = document.querySelectorAll('.select-picker');
        [...elements].map((element) => {
            new Choices(element, {
                placeholder: true,
                itemSelectText: '@lang('admin.Click to select item')',
            });
        })

        const bootstrapModal = new bootstrap.Modal(document.getElementById('mediaGallery'));
        function openModal(type, imageDimension, numberOfSelectable=1){
            bootstrapModal.show();
            getImages();
            allowClick(numberOfSelectable);
            type === "featured" ? setLayout('<img class="img-responsive" src="">', 'image-container') : setLayout('<img class="img-responsive" src="">', 'image-container image-gallery');

            let remove = type === "gallery";

            let galleryData = {
                className: "{{ class_basename($product) }}",
                type: type,
                numberOfImages: numberOfSelectable,
                dimension: imageDimension,
                id: {{ $product->id }},
                remove
            };

            const button = refreshEventListener(document.getElementById('addImageButton'));
            button.addEventListener('click', () => {
                bootstrapModal.hide();
                save(galleryData, () => {
                    if(type === 'featured') fireToast('success', '@lang('admin.Featured image successfully added!')');
                    else fireToast('success', '@lang('admin.Gallery images successfully added!')');
                });
            });
        }
    </script>
@endsection

