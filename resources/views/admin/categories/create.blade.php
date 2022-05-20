@extends('admin.layout')
@section('custom_css')
    <link href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="content-header-text">@lang('admin.Categories') / @lang('admin.create')</div>
        </section>
        <section class="content-container">
            <form method="POST" class="crud-form">
                <input type="hidden" name="featured_image" id="featured_image" value="">
                @csrf
                <div class="form-group col-md-6" >
                    <label for="name">@lang('admin.Name')</label>
                    <input type="text" class="form-control @error('name') input-error-danger @enderror" id="name" name="name" value="{{old('name')}}" placeholder="@lang('admin.Name')">
                    @error('name') <span style="color:red">{{$message}}</span>@enderror
                </div>
                <div class="form-group col-md-6" >
                    <label for="featured">@lang('admin.Featured')</label>
                    <div class="col-md-6" style="margin-top: 5px">
                        <div class="pretty p-default p-round p-thick">
                            <input type="radio" name="featured" value="1" {{ old('featured') == 1 ? 'checked' : '' }} />
                            <div class="state p-primary-o">
                                <label>@lang('admin.Yes')</label>
                            </div>
                        </div>
                        <div class="pretty p-default p-round p-thick">
                            <input type="radio" name="featured" value="0" {{ old('featured') == 0 ? 'checked' : '' }} />
                            <div class="state p-primary-o">
                                <label>@lang('admin.No')</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6" style="margin-bottom: 10px; margin-top: 10px">
                    <label for="featured_image">@lang('admin.Featured image')</label>
                    <button type="button" onclick="openModal('featured', 'm')" class="btn float-end btn-sm btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;@lang('admin.Change image')</button>
                    <div class="image-container" id="featured">
                        <img class="img-responsive" src="{{ Storage::url('/imagePlaceholder.png') }}">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary" style="position:absolute; bottom:10%">@lang('admin.Save')</button>
                </div>
            </form>
        </section>
    </div>
    @include('admin.media.gallery_modal')
@endsection
@section('custom_scripts')
    <script>
        const bootstrapModal = new bootstrap.Modal(document.getElementById('mediaGallery'));
        function openModal(type, imageDimension, numberOfSelectable=1){
            bootstrapModal.show();
            getImages();
            allowClick(numberOfSelectable);
            type === "featured" ? setLayout('<img class="img-responsive" src="">', 'image-container') : setLayout('<img class="img-responsive" src="">', 'image-container image-gallery');

            let galleryData = {
                type: type,
                numberOfImages: numberOfSelectable,
                dimension: imageDimension,
            };

            const button = refreshEventListener(document.getElementById('addImageButton'));
            button.addEventListener('click', () => {
                bootstrapModal.hide();
                setImagesOnCreateForm(galleryData,  () => {
                    if(type === 'featured') fireToast('success', '@lang('admin.Featured image successfully added!')');
                    else fireToast('success', '@lang('admin.Gallery images successfully added!')');
                });
            });

        }
    </script>
@endsection

